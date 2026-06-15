@props(['command', 'output'])

<div class="terminal bg-black text-white font-mono text-sm border border-[var(--color-border-inverse)] p-6 overflow-x-auto">
    <div class="flex items-center gap-2 mb-4 border-b border-neutral-800 pb-2">
        <span class="w-3 h-3 rounded-full bg-red-500/80 inline-block"></span>
        <span class="w-3 h-3 rounded-full bg-yellow-500/80 inline-block"></span>
        <span class="w-3 h-3 rounded-full bg-green-500/80 inline-block"></span>
        <span class="text-xs text-neutral-500 ml-2">bash</span>
    </div>
    <div class="flex items-start gap-2">
        <span class="terminal-prompt select-none">$</span>
        <span class="terminal-command font-bold text-white">{{ $command }}</span>
    </div>
    <div class="terminal-output text-neutral-400 mt-2 whitespace-pre-wrap leading-relaxed">{{ $output }}</div>
</div>
