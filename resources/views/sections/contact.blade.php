<section id="contact" class="py-24 px-6 md:px-12 bg-[#000000] text-white border-t border-neutral-900 overflow-hidden">
    <div class="max-w-7xl mx-auto w-full">
        <div class="reveal mb-16">
            <span class="text-xs font-mono uppercase tracking-widest text-[var(--color-accent)] mb-3 block">
                SEC_05 // INTERACTION
            </span>
            <h2 class="text-3xl sm:text-4xl font-display font-bold uppercase tracking-wider text-white">
                CONTACT
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 max-w-6xl mx-auto items-start">
            <!-- Left Side: Large Text & Contact Details -->
            <div class="lg:col-span-6 reveal">
                <h3 class="text-4xl sm:text-5xl font-display font-bold uppercase tracking-wider text-white mb-6 leading-tight">
                    LET'S BUILD<br>SOMETHING.
                </h3>
                
                <p class="font-body text-sm text-neutral-400 max-w-md mb-8 leading-relaxed">
                    Have an idea, project, or opening that requires high-performance backend architecture? Let's connect.
                </p>

                <!-- Email Link -->
                @if(!empty($portfolio['contact']['email']))
                    <a href="mailto:{{ $portfolio['contact']['email'] }}" class="font-display text-xl sm:text-2xl font-bold tracking-widest text-[var(--color-accent)] hover:text-white transition-colors duration-300 block mb-12">
                        {{ $portfolio['contact']['email'] }}
                    </a>
                @endif

                <!-- Command terminal display -->
                <x-terminal-block 
                    command="curl -X POST https://khedr.dev/api/contact" 
                    output='{ "status": "online", "message": "Connection established. Awaiting input..." }' 
                />
            </div>

            <!-- Right Side: Minimal Form -->
            <div class="lg:col-span-6 reveal border border-neutral-900 p-8 bg-[#030303]">
                <form action="#" method="POST" class="space-y-6" onsubmit="event.preventDefault(); alert('Message sent (Mocked).');">
                    <div>
                        <input type="text" name="name" required placeholder="NAME" class="w-full bg-transparent border-b border-neutral-800 focus:border-white focus:outline-none text-sm font-mono py-3 uppercase tracking-wider transition-colors duration-300" />
                    </div>
                    <div>
                        <input type="email" name="email" required placeholder="EMAIL" class="w-full bg-transparent border-b border-neutral-800 focus:border-white focus:outline-none text-sm font-mono py-3 uppercase tracking-wider transition-colors duration-300" />
                    </div>
                    <div>
                        <textarea name="message" rows="4" required placeholder="MESSAGE" class="w-full bg-transparent border-b border-neutral-800 focus:border-white focus:outline-none text-sm font-mono py-3 uppercase tracking-wider transition-colors duration-300 resize-none"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full btn btn-accent hover:bg-[var(--color-accent)] hover:text-white transition-colors duration-300 py-4 font-display font-bold">
                            SEND MESSAGE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
