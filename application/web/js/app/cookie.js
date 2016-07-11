$(document).ready(function(){
     $.cookieBar({
     	message: 'Nous utilisons les cookies pour suivre l\'utilisation et les préférences choisies sur ce site.',
		acceptButton: true,
		acceptText: 'J\'accepte',
		acceptFunction: null,
		declineButton: false,
		declineText: 'Disable Cookies',
		declineFunction: null,
		policyButton: false,
		policyText: 'Privacy Policy',
		policyURL: '/privacy-policy/',
		autoEnable: true,
		acceptOnContinue: false,
		acceptOnScroll: false,
		acceptAnyClick: false,
		expireDays: 365,
		renewOnVisit: true,
		forceShow: false,
		effect: 'slide',
		element: 'footer',
		append: false,
		fixed: true,
		bottom: true,
		zindex: '',
		domain: 'www.example.com',
		referrer: 'www.example.com'
     });
});