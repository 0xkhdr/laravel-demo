@props([
    'language' => 'text',
    'title' => null,
    'code' => '',
    'showLineNumbers' => false,
])

<div class="terminal" data-language="{{ $language }}">
    <!-- Terminal header with title and copy button -->
    <div class="terminal__header">
        @if($title)
            <span class="terminal__title">{{ $title }}</span>
        @endif
        <button class="terminal__copy-btn" data-copy-btn aria-label="Copy code">
            <span class="terminal__copy-text">Copy</span>
        </button>
    </div>

    <!-- Terminal body with code -->
    <div class="terminal__body">
        <pre class="terminal__pre"><code class="terminal__code" data-code-content>@php
    // Basic syntax highlighting for common patterns
    $highlighted = $code;

    // Keywords highlighting
    $keywords = ['function', 'class', 'const', 'let', 'var', 'if', 'else', 'for', 'while', 'return', 'echo', 'public', 'private', 'protected', 'static', 'async', 'await'];
    foreach ($keywords as $keyword) {
        $highlighted = preg_replace('/\b' . $keyword . '\b/', '<span class="keyword">' . $keyword . '</span>', $highlighted);
    }

    // String highlighting (single quotes, double quotes, backticks)
    $highlighted = preg_replace('/(\'[^\']*\'|"[^"]*"|`[^`]*`)/', '<span class="string">$1</span>', $highlighted);

    // Comment highlighting
    $highlighted = preg_replace('/(\/\/.*$|\/\*.*?\*\/|#.*$)/m', '<span class="comment">$1</span>', $highlighted);
@endphp{!! $highlighted !!}</code></pre>
    </div>

    <!-- Copy toast notification -->
    <div class="terminal__toast" data-toast aria-live="polite" aria-hidden="true">
        <span class="terminal__toast-text">Copied!</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyBtns = document.querySelectorAll('[data-copy-btn]');

    copyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const terminal = btn.closest('[data-language]');
            const codeElement = terminal.querySelector('[data-code-content]');
            const code = codeElement.textContent;
            const toast = terminal.querySelector('[data-toast]');

            // Copy to clipboard
            navigator.clipboard.writeText(code).then(() => {
                // Show toast
                toast.setAttribute('aria-hidden', 'false');
                toast.classList.add('terminal__toast--visible');

                // Hide after 2 seconds
                setTimeout(() => {
                    toast.classList.remove('terminal__toast--visible');
                    toast.setAttribute('aria-hidden', 'true');
                }, 2000);

                // Change button text temporarily
                const text = btn.querySelector('.terminal__copy-text');
                const original = text.textContent;
                text.textContent = 'Copied!';
                setTimeout(() => {
                    text.textContent = original;
                }, 2000);
            });
        });
    });
});
</script>
