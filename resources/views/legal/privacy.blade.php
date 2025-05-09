@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Privacy Policy</h1>
        
        <div class="prose dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Last updated: {{ date('F d, Y') }}
            </p>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">1. Introduction</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BrightPath ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our educational platform, including any related mobile applications (collectively, the "Platform").
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Please read this Privacy Policy carefully. By accessing or using our Platform, you acknowledge that you have read, understood, and agree to be bound by all the terms of this Privacy Policy. If you do not agree with our policies and practices, please do not use our Platform.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">2. Information We Collect</h2>
                
                <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-3">2.1 Personal Information</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We may collect personal information that you voluntarily provide to us when you register on the Platform, express interest in obtaining information about us or our products and services, participate in activities on the Platform, or otherwise contact us. The personal information we collect may include:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Name, email address, and contact details</li>
                    <li>Username and password</li>
                    <li>Profile information and educational background</li>
                    <li>Payment information (processed securely through our payment processors)</li>
                    <li>Course preferences and learning history</li>
                    <li>Communications with us</li>
                </ul>
                
                <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-3">2.2 Automatically Collected Information</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    When you access our Platform, we may automatically collect certain information about your device and usage of the Platform, including:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Device information (such as your IP address, browser type, operating system)</li>
                    <li>Usage data (such as pages visited, time spent on pages, links clicked)</li>
                    <li>Location information (if you grant permission)</li>
                    <li>Cookies and similar tracking technologies</li>
                </ul>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">3. How We Use Your Information</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We may use the information we collect for various purposes, including:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>Providing, maintaining, and improving our Platform</li>
                    <li>Processing your transactions and managing your account</li>
                    <li>Personalizing your learning experience</li>
                    <li>Communicating with you about your account, updates, and educational content</li>
                    <li>Analyzing usage patterns to enhance our Platform</li>
                    <li>Protecting against unauthorized access and fraud</li>
                    <li>Complying with legal obligations</li>
                </ul>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">4. Sharing Your Information</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We may share your information in the following situations:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li><strong>Service Providers:</strong> We may share your information with third-party vendors, service providers, and other partners who help us provide our services.</li>
                    <li><strong>Legal Requirements:</strong> We may disclose your information if required to do so by law or in response to valid requests by public authorities.</li>
                    <li><strong>Business Transfers:</strong> We may share or transfer your information in connection with a merger, acquisition, reorganization, or sale of assets.</li>
                    <li><strong>With Your Consent:</strong> We may share your information for other purposes with your consent.</li>
                </ul>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">5. Data Security</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We implement appropriate technical and organizational measures to protect the security of your personal information. However, please be aware that no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">6. Your Privacy Rights</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Depending on your location, you may have certain rights regarding your personal information, including:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-600 dark:text-gray-300">
                    <li>The right to access your personal information</li>
                    <li>The right to correct inaccurate or incomplete information</li>
                    <li>The right to delete your personal information</li>
                    <li>The right to restrict or object to processing</li>
                    <li>The right to data portability</li>
                    <li>The right to withdraw consent</li>
                </ul>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    To exercise these rights, please contact us using the information provided in the "Contact Us" section below.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">7. Changes to This Privacy Policy</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. You are advised to review this Privacy Policy periodically for any changes.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">8. Contact Us</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at:
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Email: privacy@brightpath.com<br>
                    Address: 123 Education St, Learning City
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
