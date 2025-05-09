@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Accessibility Statement</h1>
        
        <div class="prose dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Last updated: {{ date('F d, Y') }}
            </p>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Our Commitment</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath is committed to ensuring digital accessibility for people with disabilities. We are continually improving the user experience for everyone and applying the relevant accessibility standards.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Conformance Status</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    The Web Content Accessibility Guidelines (WCAG) define requirements for designers and developers to improve accessibility for people with disabilities. It defines three levels of conformance: Level A, Level AA, and Level AAA.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath is partially conformant with WCAG 2.1 level AA. Partially conformant means that some parts of the content do not fully conform to the accessibility standard.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Accessibility Features</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath includes the following accessibility features:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Keyboard navigation support</li>
                    <li>Text alternatives for non-text content</li>
                    <li>Color contrast that meets WCAG 2.1 AA standards</li>
                    <li>Resizable text without loss of content or functionality</li>
                    <li>Multiple ways to navigate content</li>
                    <li>Clear headings and labels</li>
                    <li>Focus indicators for keyboard navigation</li>
                    <li>Dark mode for users with light sensitivity</li>
                </ul>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Limitations and Alternatives</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Despite our best efforts to ensure accessibility of BrightPath, there may be some limitations. Below is a description of known limitations, and potential solutions:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li><strong>Videos:</strong> Some older video content may not have captions or audio descriptions. We are working to update these videos. Please contact us for alternative formats.</li>
                    <li><strong>PDFs:</strong> Some of our older PDF documents may not be fully accessible. We are working to remediate these documents. Please contact us if you encounter inaccessible PDFs.</li>
                    <li><strong>Third-party content:</strong> Some third-party content or functionality may not be fully accessible. We are working with our vendors to address these issues.</li>
                </ul>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Feedback</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We welcome your feedback on the accessibility of BrightPath. Please let us know if you encounter accessibility barriers:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Email: accessibility@brightpath.com</li>
                    <li>Phone: +1 234 567 8900</li>
                    <li>Postal address: 123 Education St, Learning City</li>
                </ul>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We try to respond to feedback within 3 business days.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Assessment Approach</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath assessed the accessibility of our platform by the following approaches:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Self-evaluation</li>
                    <li>External evaluation using automated tools</li>
                    <li>User testing with assistive technologies</li>
                </ul>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Compatibility with Browsers and Assistive Technology</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath is designed to be compatible with the following assistive technologies:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Screen readers (including NVDA, JAWS, VoiceOver, and TalkBack)</li>
                    <li>Screen magnification software</li>
                    <li>Speech recognition software</li>
                    <li>Keyboard-only navigation</li>
                </ul>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath is compatible with recent versions of major browsers, including Chrome, Firefox, Safari, and Edge.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Technical Specifications</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Accessibility of BrightPath relies on the following technologies to work with the particular combination of web browser and any assistive technologies or plugins installed on your computer:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>HTML</li>
                    <li>WAI-ARIA</li>
                    <li>CSS</li>
                    <li>JavaScript</li>
                </ul>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    These technologies are relied upon for conformance with the accessibility standards used.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Continuous Improvement</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath is committed to continuous improvement of our accessibility efforts. We regularly review our platform for accessibility issues and work to address them. We also provide accessibility training to our staff.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
