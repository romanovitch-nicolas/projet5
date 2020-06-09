class Display {
	constructor() {
		this.burger = document.querySelector("#burger");
		this.menu = document.querySelector("header");
		this.background = document.querySelector("#background");
    	this.homeProducts = document.querySelectorAll(".home_product");
    	this.products = document.querySelectorAll(".product");
    	this.commentButton = document.querySelector("#postcomments span.button");
    	this.commentForm = document.querySelector("#postcomments #form");
    	this.shopButton = document.querySelector("#adminshops span.button");
    	this.shopForm = document.querySelector("#adminshops form");
    	this.editProductImageButton = document.querySelector("#editproduct span.button");
    	this.editProductImageInput = document.querySelector("#editproduct input[type='file']");
    	this.editProductImageInfo = document.querySelector("#editproduct p.date");
    	this.editPostImageButton = document.querySelector("#editpost span.button");
    	this.editPostImageInput = document.querySelector("#editpost input[type='file']");
    	this.editPostImageInfo = document.querySelector("#editpost p.date");
    	this.editHomeImageButton = document.querySelector("#edithome span.button");
    	this.editHomeImageInput = document.querySelector("#edithome input[type='file']");
    	this.editHomeImageInfo = document.querySelector("#edithome p.date");
    	this.editAboutImageButtonOne = document.querySelector("#editabout span.button");
    	this.editAboutImageInputOne = document.querySelector("#editabout input[type='file']");
    	this.editAboutImageInfoOne = document.querySelector("#editabout p.date");
    	this.editAboutImageButtonTwo = document.querySelector("#editabout span.two");
    	this.editAboutImageInputTwo = document.querySelector("#editabout input[type='file'].two");
    	this.editAboutImageInfoTwo = document.querySelector("#editabout p.two");
    	this.initDisplay();
	}

	initDisplay() {
		this.burger.addEventListener("click", function() {
			this.menu.style.display = "block";
			this.menu.style.animation = "0.5s slidein";
			this.background.style.display = "block";
		}.bind(this));

		this.background.addEventListener("click", function() {
			this.menu.style.display = "none";
			this.background.style.display = "none";
		}.bind(this));

		window.addEventListener("resize", function() {
			if (window.matchMedia("(min-width: 1367px)").matches) {
				if(this.menu.style.display = "none") {
					this.menu.style.display = "block";
					this.menu.style.animation = "none";
				};
			}
			else {
				this.menu.style.display = "none";
				this.background.style.display = "none";
			};
		}.bind(this));

		this.homeProducts.forEach(function (homeProduct) {
			let homeProductDescription = homeProduct.querySelector(".home_product_description");
			if(homeProductDescription !== null) {
				homeProductDescription.classList.add("invisible");
				homeProduct.addEventListener("click", function() {
					homeProductDescription.classList.toggle("invisible");
					homeProductDescription.style.animation = "0.8s opacity";
				});
			};
		});

		this.products.forEach(function (product) {
			let productDescription = product.querySelectorAll("p");
			if(productDescription !== null) {
				productDescription.forEach(function (description) {
					description.classList.add("invisible");
				});
				product.addEventListener("click", function() {
					productDescription.forEach(function (description) {
						description.classList.toggle("invisible");
						description.style.animation = "0.8s opacity";
					});
				});
			};
		});

		if(this.commentForm !== null) {
			this.commentButton.addEventListener("click", function() {
				this.commentForm.classList.toggle("invisible");
				this.commentForm.style.animation = "0.5s translate";
			}.bind(this));
		};

		if(this.shopForm !== null) {
			this.shopForm.classList.add("invisible");
			this.shopButton.addEventListener("click", function() {
				this.shopForm.classList.toggle("invisible");
				this.shopForm.style.animation = "0.5s translate";
			}.bind(this));
		};

		if(this.editProductImageInput !== null) {
			this.editProductImageInput.classList.add("invisible");
			this.editProductImageInfo.classList.add("invisible");
			this.editProductImageButton.addEventListener("click", function() {
				this.editProductImageInput.classList.toggle("invisible");
				this.editProductImageInput.style.animation = "0.3s translate";
				this.editProductImageInfo.classList.toggle("invisible");
				this.editProductImageInfo.style.animation = "0.3s translate";
			}.bind(this));
		};

		if(this.editPostImageInput !== null) {
			this.editPostImageInput.classList.add("invisible");
			this.editPostImageInfo.classList.add("invisible");
			this.editPostImageButton.addEventListener("click", function() {
				this.editPostImageInput.classList.toggle("invisible");
				this.editPostImageInput.style.animation = "0.3s translate";
				this.editPostImageInfo.classList.toggle("invisible");
				this.editPostImageInfo.style.animation = "0.3s translate";
			}.bind(this));
		};

		if(this.editHomeImageInput !== null) {
			this.editHomeImageInput.classList.add("invisible");
			this.editHomeImageInfo.classList.add("invisible");
			this.editHomeImageButton.addEventListener("click", function() {
				this.editHomeImageInput.classList.toggle("invisible");
				this.editHomeImageInput.style.animation = "0.3s translate";
				this.editHomeImageInfo.classList.toggle("invisible");
				this.editHomeImageInfo.style.animation = "0.3s translate";
			}.bind(this));
		};

		if(this.editAboutImageInputOne !== null) {
			this.editAboutImageInputOne.classList.add("invisible");
			this.editAboutImageInfoOne.classList.add("invisible");
			this.editAboutImageButtonOne.addEventListener("click", function() {
				this.editAboutImageInputOne.classList.toggle("invisible");
				this.editAboutImageInputOne.style.animation = "0.3s translate";
				this.editAboutImageInfoOne.classList.toggle("invisible");
				this.editAboutImageInfoOne.style.animation = "0.3s translate";
			}.bind(this));
		};

		if(this.editAboutImageInputTwo !== null) {
			this.editAboutImageInputTwo.classList.add("invisible");
			this.editAboutImageInfoTwo.classList.add("invisible");
			this.editAboutImageButtonTwo.addEventListener("click", function() {
				this.editAboutImageInputTwo.classList.toggle("invisible");
				this.editAboutImageInputTwo.style.animation = "0.3s translate";
				this.editAboutImageInfoTwo.classList.toggle("invisible");
				this.editAboutImageInfoTwo.style.animation = "0.3s translate";
			}.bind(this));
		};
	}
}

let display = new Display;