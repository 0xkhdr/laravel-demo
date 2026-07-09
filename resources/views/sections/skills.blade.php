<section class="section bg-white text-gray-900" id="skills">
    <div class="max-w-3xl mx-auto px-4 md:px-8">
        <x-section-header
            title="Skills"
            subtitle="What I know"
            description="Expertise across frontend, backend, and development tools"
            align="center"
        />

        <div class="mt-12 space-y-10">
            <!-- Frontend Skills -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Frontend</h3>
                <div class="flex flex-wrap gap-3">
                    @php
                        $frontendSkills = [
                            'React',
                            'Vue.js',
                            'TypeScript',
                            'Tailwind CSS',
                            'Accessible UI',
                            'Responsive Design',
                        ];
                    @endphp
                    @foreach ($frontendSkills as $skill)
                        <x-skill-tag :skill="$skill" variant="outline" />
                    @endforeach
                </div>
            </div>

            <!-- Backend Skills -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Backend</h3>
                <div class="flex flex-wrap gap-3">
                    @php
                        $backendSkills = [
                            'Laravel',
                            'PHP',
                            'Node.js',
                            'PostgreSQL',
                            'RESTful APIs',
                            'System Design',
                        ];
                    @endphp
                    @foreach ($backendSkills as $skill)
                        <x-skill-tag :skill="$skill" variant="outline" />
                    @endforeach
                </div>
            </div>

            <!-- Tools Skills -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tools</h3>
                <div class="flex flex-wrap gap-3">
                    @php
                        $toolsSkills = [
                            'Git',
                            'Docker',
                            'Figma',
                            'VS Code',
                            'Command Line',
                            'Testing',
                        ];
                    @endphp
                    @foreach ($toolsSkills as $skill)
                        <x-skill-tag :skill="$skill" variant="outline" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
