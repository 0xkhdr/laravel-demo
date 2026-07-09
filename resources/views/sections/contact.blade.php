<!-- Contact Section: Dark theme call-to-action with email and social links -->
<section class="relative w-full py-20 px-4 bg-black" data-theme="dark">
    <div class="mx-auto max-w-2xl">
        <!-- Section Header Component with "Get In Touch" heading -->
        <x-section-header
            :title="'Get In Touch'"
            :description="'I\'d love to hear from you. Let\'s collaborate and create something amazing together.'"
            :align="'center'"
        />

        <!-- CTA Container: Centered content with email button and contact info -->
        <div class="flex flex-col items-center justify-center gap-8 mt-12">
            <!-- Primary CTA: Large button "Send me an email" with mailto link -->
            <x-btn
                href="mailto:0xkhdr@gmail.com"
                class="bg-violet-600 hover:bg-violet-700 text-white font-semibold px-8 py-4 rounded-lg text-lg transition-colors"
            >
                Send me an email
            </x-btn>

            <!-- Contact Information Section -->
            <div class="w-full space-y-6 text-center">
                <!-- Email Contact Link -->
                <x-contact-link :link="['href' => 'mailto:0xkhdr@gmail.com', 'label' => 'Email', 'value' => '0xkhdr@gmail.com']" />

                <!-- Social Media Links -->
                <div class="flex justify-center gap-6 pt-4">
                    <!-- GitHub Link -->
                    <a
                        href="https://github.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-gray-300 hover:text-violet-400 transition-colors text-sm font-medium"
                        title="GitHub"
                    >
                        GitHub
                    </a>

                    <!-- LinkedIn Link -->
                    <a
                        href="https://linkedin.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-gray-300 hover:text-violet-400 transition-colors text-sm font-medium"
                        title="LinkedIn"
                    >
                        LinkedIn
                    </a>

                    <!-- Twitter Link -->
                    <a
                        href="https://twitter.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-gray-300 hover:text-violet-400 transition-colors text-sm font-medium"
                        title="Twitter"
                    >
                        Twitter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
