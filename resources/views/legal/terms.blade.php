@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Terms of Service</h1>
        
        <div class="prose dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Last updated: {{ date('F d, Y') }}
            </p>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">1. Agreement to Terms</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    These Terms of Service ("Terms") constitute a legally binding agreement between you and BrightPath ("we," "us," or "our") governing your access to and use of the BrightPath website, mobile application, and educational services (collectively, the "Platform").
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    By accessing or using our Platform, you agree to be bound by these Terms. If you do not agree to these Terms, you must not access or use the Platform.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">2. Eligibility</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    You must be at least 16 years old to use our Platform. If you are under 18, you represent that you have your parent's or legal guardian's permission to use the Platform and that they have read and agree to these Terms on your behalf.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    By using our Platform, you represent and warrant that you meet all eligibility requirements we outline in these Terms. We may still refuse to let certain people access or use the Platform, and we reserve the right to change our eligibility criteria at any time.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">3. User Accounts</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    To access certain features of our Platform, you may need to register for an account. When you register, you agree to provide accurate, current, and complete information and to update this information to maintain its accuracy.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account or any other breach of security.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We reserve the right to disable any user account at any time, including if we believe you have violated these Terms.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">4. Platform Use and Conduct</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    You agree to use the Platform only for lawful purposes and in accordance with these Terms. You agree not to:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Use the Platform in any way that violates any applicable law or regulation</li>
                    <li>Impersonate any person or entity, or falsely state or misrepresent your affiliation with a person or entity</li>
                    <li>Engage in any conduct that restricts or inhibits anyone's use or enjoyment of the Platform</li>
                    <li>Attempt to gain unauthorized access to any part of the Platform</li>
                    <li>Use the Platform to transmit any harmful or malicious code</li>
                    <li>Collect or harvest any information from the Platform without authorization</li>
                    <li>Copy, modify, distribute, sell, or lease any part of our Platform without our permission</li>
                </ul>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">5. Intellectual Property Rights</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    The Platform and its entire contents, features, and functionality (including but not limited to all information, software, text, displays, images, video, and audio) are owned by BrightPath, its licensors, or other providers and are protected by copyright, trademark, patent, and other intellectual property laws.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    You are granted a limited, non-exclusive, non-transferable, and revocable license to access and use the Platform for personal, non-commercial purposes. You must not reproduce, distribute, modify, create derivative works of, publicly display, publicly perform, republish, download, store, or transmit any of the material on our Platform, except as permitted by these Terms.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">6. User Content</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Our Platform may allow you to post, submit, publish, display, or transmit content ("User Content"). By providing User Content, you grant us a non-exclusive, worldwide, royalty-free, sublicensable, and transferable license to use, reproduce, modify, adapt, publish, translate, distribute, and display such User Content in connection with operating and providing our services.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    You represent and warrant that you own or have the necessary rights to submit User Content and that your User Content does not violate the rights of any third party or any applicable law or regulation.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">7. Payment Terms</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Certain aspects of our Platform may require payment. By purchasing any paid services, you agree to pay all fees and charges associated with your account on a timely basis and in the currency specified. All payments are non-refundable unless otherwise expressly stated.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We reserve the right to change our prices at any time. If we change pricing for a service you have already purchased, we will notify you before the price change becomes effective.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">8. Limitation of Liability</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    To the maximum extent permitted by law, BrightPath and its affiliates, officers, employees, agents, partners, and licensors shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your access to or use of or inability to access or use the Platform.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">9. Termination</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We may terminate or suspend your account and access to the Platform immediately, without prior notice or liability, for any reason, including if you breach these Terms.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Upon termination, your right to use the Platform will immediately cease. All provisions of these Terms which by their nature should survive termination shall survive, including ownership provisions, warranty disclaimers, indemnity, and limitations of liability.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">10. Changes to Terms</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We reserve the right to modify these Terms at any time. If we make changes, we will provide notice by posting the updated Terms on this page and updating the "Last updated" date. Your continued use of the Platform after any such changes constitutes your acceptance of the new Terms.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">11. Contact Us</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    If you have any questions about these Terms, please contact us at:
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Email: legal@brightpath.com<br>
                    Address: 123 Education St, Learning City
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
