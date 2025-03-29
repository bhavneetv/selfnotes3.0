<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="../../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../../public/assest/icon/site.webmanifest" />
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --background: #0f172a;
            --surface: #1e293b;
            --text: #f1f5f9;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--background);
            color: var(--text);
            min-height: 100vh;
            font-family: system-ui, -apple-system, sans-serif;
            /* cursor:; */
        }

        .glass-nav {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-btn:hover {
            background: rgba(59, 130, 246, 0.2);
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        .nav-btn:active {
            transform: translateY(0);
        }

        .nav-btn svg {
            width: 20px;
            height: 20px;
            color: var(--primary);
            transition: all 0.3s;
        }

        .nav-btn:hover svg {
            color: #60a5fa;
        }

        .nav-btn.active {
            background: var(--primary);
        }

        .nav-btn.active svg {
            color: white;
        }

        .tooltip {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%) scale(0.8);
            background: rgba(15, 23, 42, 0.9);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            color: var(--text);
            opacity: 0;
            transition: all 0.3s;
            pointer-events: none;
        }

        .nav-btn:hover .tooltip {
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            z-index: 50;
        }

        .modal.active {
            display: flex;
        }

        .form-radio {
            width: 1.2rem;
            height: 1.2rem;
            border-radius: 50%;
            border: 2px solid var(--primary);
            appearance: none;
            position: relative;
            cursor: pointer;
        }

        .form-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.6rem;
            height: 0.6rem;
            border-radius: 50%;
            background-color: var(--primary);
        }

        .modal-content {
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s;
        }

        .modal.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 glass-nav z-40 h-16">
        <div class="max-w-7xl mx-auto px-4 h-full">
            <div class="flex items-center justify-between h-full">
                <button id="backBtn" class="nav-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="tooltip">Back</span>
                </button>
                <div class="flex items-center space-x-4">
                    <button id="markReadBtn" class="nav-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="tooltip">Mark as Read</span>
                    </button>
                    <button id="reportBtn" class="nav-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="tooltip">Report Issue</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- PDF Viewer -->
    <main class="pt-16 h-screen">
        <iframe
            id="pdfFrame"
            src=""
            class="w-full h-full border-0 bg-surface"
        ></iframe>
    </main>

    <!-- Report Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content bg-gray-900 rounded-2xl p-6 m-auto max-w-md border border-blue-900/20 shadow-2xl" style="width:90% ;">
            <div class="flex justify-between items-center mb-8">
                <div class="text-blue-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <button id="closeModal" class="nav-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="reportForm" class="space-y-3" action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="7e4074bc-1245-4410-bfd5-87f8d050dffd">
                <div class="space-y-4" style="width: 350px;">
                    <div class="space-y-4">
                        <label class="flex items-center space-x-3 cursor-pointer group p-3 rounded-lg hover:bg-blue-500/10 transition-colors">
                            <input type="radio" name="issueType" value="wrong-page" class="form-radio">
                            <span class="text-gray-200 group-hover:text-blue-400 transition-colors">Wrong Page</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group p-3 rounded-lg hover:bg-blue-500/10 transition-colors">
                            <input type="radio" name="issueType" value="handwritten" class="form-radio">
                            <span class="text-gray-200 group-hover:text-blue-400 transition-colors">Handwritten Issue</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group p-3 rounded-lg hover:bg-blue-500/10 transition-colors">
                            <input type="radio" name="issueType" value="quality" class="form-radio">
                            <span class="text-gray-200 group-hover:text-blue-400 transition-colors">Poor Quality</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group p-3 rounded-lg hover:bg-blue-500/10 transition-colors">
                            <input type="text" name="issueType" value="note_id" id="id" disabled>
                            <span class="text-gray-200 group-hover:text-blue-400 transition-colors">Note Id</span>
                        </label>
                    </div>
                </div>
                <div>
                    <textarea name="description" id="description" class="w-full p-4 bg-gray-800/50 border border-gray-700 rounded-xl text-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-500/20 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all resize-none"
                        rows="4"
                        placeholder="Describe the issue..."
                    ></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="nav-btn" id="cancelReport">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <button type="submit" class="nav-btn active">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Back button functionality
       
    </script>
    <script src="pdf.js"></script>
</body>
</html>