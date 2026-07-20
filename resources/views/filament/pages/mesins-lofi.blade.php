<x-filament-panels::page>
    <style>
        html {
            filter: grayscale(1);
        }

        .lofi-line {
            border-radius: 9999px;
            background: rgb(229 231 235);
        }

        .dark .lofi-line {
            background: rgb(255 255 255 / 0.18);
        }
    </style>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="flex min-h-16 flex-col gap-3 border-b border-gray-200 px-4 py-3 dark:border-white/10 sm:flex-row sm:items-center sm:justify-end">
            <div class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 py-3 dark:border-white/10 dark:bg-white/5 sm:w-64">
                <div class="lofi-line h-3 w-20"></div>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative h-6 w-6">
                    <div class="lofi-line h-6 w-6 rounded-md"></div>
                    <div class="absolute -right-1 -top-2 flex h-5 min-w-5 items-center justify-center rounded-full border border-gray-300 bg-gray-100 px-1 text-xs font-semibold text-gray-700 dark:border-white/10 dark:bg-gray-800 dark:text-gray-300">
                        x
                    </div>
                </div>
                <div class="flex gap-1">
                    <div class="h-4 w-1.5 rounded-sm bg-gray-300 dark:bg-white/20"></div>
                    <div class="h-4 w-1.5 rounded-sm bg-gray-300 dark:bg-white/20"></div>
                    <div class="h-4 w-1.5 rounded-sm bg-gray-300 dark:bg-white/20"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px] table-auto text-start">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5">
                        <th class="px-6 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">xxxx</th>
                        <th class="px-6 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">xxxx</th>
                        <th class="px-6 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">xxxxx xxxxx</th>
                        <th class="px-6 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">xxxxxx</th>
                        <th class="px-6 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">xxxxxxxxxx xxxxxx</th>
                        <th class="px-6 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">xxxxxxx</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @if ($this->placeholderRows() > 0)
                        @for ($row = 0; $row < $this->placeholderRows(); $row++)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-6 py-4">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 ring-1 ring-gray-300 dark:bg-white/10 dark:ring-white/10"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="lofi-line h-3 w-20"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="lofi-line h-3 w-32"></div>
                                    <div class="lofi-line mt-2 h-2 w-20"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="h-6 w-16 rounded-md border border-gray-300 bg-gray-100 dark:border-white/10 dark:bg-white/10"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="lofi-line h-3 w-28"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="lofi-line h-3 w-20"></div>
                                </td>
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-14">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-2xl leading-none text-gray-500 dark:bg-white/10 dark:text-gray-400">
                                        x
                                    </div>
                                    <div class="mt-5 text-base font-semibold text-gray-950 dark:text-white">xx xxxxxx xxxxx</div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        (() => {
            const maskText = () => {
                const ignoredTags = new Set(['SCRIPT', 'STYLE', 'SVG', 'PATH', 'META', 'LINK']);
                const walker = document.createTreeWalker(
                    document.body,
                    NodeFilter.SHOW_TEXT,
                    {
                        acceptNode(node) {
                            const parent = node.parentElement;

                            if (!parent || ignoredTags.has(parent.tagName) || !node.nodeValue.trim()) {
                                return NodeFilter.FILTER_REJECT;
                            }

                            return NodeFilter.FILTER_ACCEPT;
                        },
                    },
                );

                const nodes = [];

                while (walker.nextNode()) {
                    nodes.push(walker.currentNode);
                }

                nodes.forEach((node) => {
                    node.nodeValue = node.nodeValue.replace(/[A-Za-z0-9]+/g, (match) => 'x'.repeat(match.length));
                });

                document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach((field) => {
                    field.setAttribute('placeholder', field.getAttribute('placeholder').replace(/[A-Za-z0-9]+/g, (match) => 'x'.repeat(match.length)));
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', maskText, { once: true });
            } else {
                maskText();
            }

            document.addEventListener('livewire:navigated', maskText);
        })();
    </script>
</x-filament-panels::page>
