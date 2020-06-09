class App {
	constructor() {
		this.cookies = document.querySelector("#cookies");
		this.acceptCookies = document.querySelector("#accept_cookies");
		this.refuseCookies = document.querySelector("#refuse_cookies");
		this.initCookies();
		this.tinyInit();
	}

	initCookies() {
		this.acceptCookies.addEventListener("click", function() {
			document.cookie = 'cookies=accept; path=/; max-age=31536000';
			this.cookies.classList.add("invisible");
		}.bind(this));

		this.refuseCookies.addEventListener("click", function() {
			document.cookie = 'cookies=refuse; path=/; max-age=86400';
			this.cookies.classList.add("invisible");
		}.bind(this));
	}

	tinyInit() {
		// Initialisation de l'éditeur de texte
        tinymce.init({
        	plugins: "paste,  link",
        	paste_as_text: true,
	        force_br_newlines: true,
	        force_p_newlines: false,
	        forced_root_block: '',
	        content_css: ['https://fonts.googleapis.com/css?family=Indie+Flower&display=swap',
	            'https://fonts.googleapis.com/css?family=Courier+Prime&display=swap',
	            'public/css/style.css'],
	        selector: '#editor, .editor',
	        height: 350,
	        statusbar: false,
	        toolbar: 'undo redo | copy cut paste | fontsizeselect | bold italic underline strikethrough | forecolor | alignleft aligncenter alignright alignjustify | outdent indent | superscript subscript | link',
	        menubar: '',
	        mobile: {
    			theme: 'mobile',
    			menubar: ''
			}
	    });
	}
}

let app = new App;