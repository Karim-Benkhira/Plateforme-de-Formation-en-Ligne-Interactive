@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Cookie Policy</h1>
        
        <div class="prose dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Last updated: {{ date('F d, Y') }}
            </p>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">1. Introduction</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    This Cookie Policy explains how BrightPath ("we", "us", or "our") uses cookies and similar technologies to recognize you when you visit our website and use our educational platform, including any related mobile applications (collectively, the "Platform"). It explains what these technologies are and why we use them, as well as your rights to control our use of them.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">2. What Are Cookies?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Cookies are small data files that are placed on your computer or mobile device when you visit a website. Cookies are widely used by website owners to make their websites work, or to work more efficiently, as well as to provide reporting information.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Cookies set by the website owner (in this case, BrightPath) are called "first-party cookies". Cookies set by parties other than the website owner are called "third-party cookies". Third-party cookies enable third-party features or functionality to be provided on or through the website (e.g., advertising, interactive content, and analytics). The parties that set these third-party cookies can recognize your computer both when it visits the website in question and also when it visits certain other websites.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">3. Why Do We Use Cookies?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We use first-party and third-party cookies for several reasons. Some cookies are required for technical reasons in order for our Platform to operate, and we refer to these as "essential" or "strictly necessary" cookies. Other cookies also enable us to track and target the interests of our users to enhance the experience on our Platform. Third parties serve cookies through our Platform for advertising, analytics, and other purposes.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">4. Types of Cookies We Use</h2>
                
                <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-3">4.1 Essential Cookies</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    These cookies are strictly necessary to provide you with services available through our Platform and to use some of its features, such as access to secure areas. Because these cookies are strictly necessary to deliver the Platform, you cannot refuse them without impacting how our Platform functions.
                </p>
                
                <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-3">4.2 Performance and Functionality Cookies</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    These cookies are used to enhance the performance and functionality of our Platform but are non-essential to their use. However, without these cookies, certain functionality may become unavailable.
                </p>
                
                <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-3">4.3 Analytics and Customization Cookies</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    These cookies collect information that is used either in aggregate form to help us understand how our Platform is being used or how effective our marketing campaigns are, or to help us customize our Platform for you.
                </p>
                
                <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-3">4.4 Advertising Cookies</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    These cookies are used to make advertising messages more relevant to you. They perform functions like preventing the same ad from continuously reappearing, ensuring that ads are properly displayed, and in some cases selecting advertisements that are based on your interests.
                </p>
                
                <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-3">4.5 Social Media Cookies</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    These cookies are used to enable you to share pages and content that you find interesting on our Platform through third-party social networking and other websites. These cookies may also be used for advertising purposes.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">5. How Can You Control Cookies?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by clicking on the appropriate opt-out links provided in the cookie banner on our Platform.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    You can also set or amend your web browser controls to accept or refuse cookies. If you choose to reject cookies, you may still use our Platform though your access to some functionality and areas may be restricted. As the means by which you can refuse cookies through your web browser controls vary from browser to browser, you should visit your browser's help menu for more information.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    In addition, most advertising networks offer you a way to opt out of targeted advertising. If you would like to find out more information, please visit <a href="http://www.aboutads.info/choices/" class="text-blue-600 dark:text-blue-400 hover:underline">http://www.aboutads.info/choices/</a> or <a href="http://www.youronlinechoices.com" class="text-blue-600 dark:text-blue-400 hover:underline">http://www.youronlinechoices.com</a>.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">6. How Often Will We Update This Cookie Policy?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    We may update this Cookie Policy from time to time in order to reflect, for example, changes to the cookies we use or for other operational, legal, or regulatory reasons. Please therefore revisit this Cookie Policy regularly to stay informed about our use of cookies and related technologies.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    The date at the top of this Cookie Policy indicates when it was last updated.
                </p>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">7. Contact Us</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    If you have any questions about our use of cookies or other technologies, please contact us at:
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
