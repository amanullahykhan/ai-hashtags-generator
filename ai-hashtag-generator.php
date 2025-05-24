<?php
$api_key = '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';
$hashtags = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_text = trim($_POST['text']);
    
    if (empty($input_text)) {
        $error = "Please enter some text to generate hashtags!";
    } else {
        $prompt = "Generate 5-10 relevant hashtags for this text. Return only hashtags separated by spaces, lowercase, no numbers. Text: $input_text";
        
        $data = [
            'model' => 'openrouter/auto',  // Let OpenRouter choose the best model
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 60
        ];

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
                'HTTP-Referer: https://yourdomain.com',  // Required by OpenRouter
                'X-Title: Hashtag Generator'             // App identifier
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => 'C:/wamp64/bin/php/php8.3.6/extras/ssl/cacert.pem',
            CURLOPT_TIMEOUT => 15
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error_msg = curl_error($ch);
        curl_close($ch);

        if ($error_msg) {
            $error = "API Connection Error: " . $error_msg;
        } elseif ($http_code != 200) {
            $error = "OpenRouter Error (HTTP $http_code): " . $response;
        } else {
            $response_data = json_decode($response, true);
            if (isset($response_data['choices'][0]['message']['content'])) {
                $hashtags = $response_data['choices'][0]['message']['content'];
                $hashtags = preg_replace('/[^a-z0-9# ]/', '', strtolower($hashtags));
                $hashtags = implode(' ', array_unique(explode(' ', $hashtags)));
            } else {
                $error = "Failed to parse API response";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Hashtag Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto max-w-2xl px-4 py-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">✨ AI Hashtag Generator</h1>
            
            <form method="POST">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Your Text</label>
                    <textarea 
                        name="text" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        rows="5"
                        placeholder="Paste your text here..."
                        required
                    ><?= htmlspecialchars($_POST['text'] ?? '') ?></textarea>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-[1.01]"
                >
                    Generate Hashtags
                </button>
            </form>

            <?php if ($error): ?>
                <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                    ⚠️ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($hashtags): ?>
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">Generated Hashtags</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex flex-wrap gap-2">
                            <?php foreach (explode(' ', $hashtags) as $tag): ?>
                                <?php if (!empty($tag)): ?>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        #<?= htmlspecialchars(trim($tag, '#')) ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">Click hashtags to copy them</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Add click-to-copy functionality
        document.querySelectorAll('.bg-blue-100').forEach(tag => {
            tag.addEventListener('click', () => {
                const text = '#' + tag.innerText.trim();
                navigator.clipboard.writeText(text).then(() => {
                    tag.classList.add('bg-green-100', 'text-green-800');
                    setTimeout(() => {
                        tag.classList.remove('bg-green-100', 'text-green-800');
                    }, 1000);
                });
            });
        });
    </script>
</body>
</html>