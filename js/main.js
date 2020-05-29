AOS.init({
	duration: 800,
	easing: 'slide'
});

(function ($) {

	"use strict";

	var isMobile = {
		Android: function () {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function () {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function () {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function () {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function () {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function () {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};


	$(window).stellar({
		responsive: true,
		parallaxBackgrounds: true,
		parallaxElements: true,
		horizontalScrolling: false,
		hideDistantElements: false,
		scrollProperty: 'scroll'
	});


	var fullHeight = function () {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function () {
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	// loader
	var loader = function () {
		setTimeout(function () {
			if ($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	// Scrollax
	$.Scrollax();

	var carousel = function () {
		$('.home-slider').owlCarousel({
			loop: true,
			autoplay: true,
			margin: 0,
			animateOut: 'fadeOut',
			animateIn: 'fadeIn',
			nav: false,
			autoplayHoverPause: false,
			items: 1,
			navText: ["<span class='ion-md-arrow-back'></span>", "<span class='ion-chevron-right'></span>"],
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		});

		$('.carousel-testimony').owlCarousel({
			center: true,
			loop: true,
			items: 1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 3
				},
				1000: {
					items: 3
				}
			}
		});

	};
	carousel();

	$('nav .dropdown').hover(function () {
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function () {
		var $this = $(this);
		// timer;
		// timer = setTimeout(function(){
		$this.removeClass('show');
		$this.find('> a').attr('aria-expanded', false);
		// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
		console.log('show');
	});

	// scroll
	var scrollWindow = function () {
		$(window).scroll(function () {
			var $w = $(this),
				st = $w.scrollTop(),
				navbar = $('.ftco_navbar'),
				sd = $('.js-scroll-wrap');

			if (st > 150) {
				if (!navbar.hasClass('scrolled')) {
					navbar.addClass('scrolled');
				}
			}
			if (st < 150) {
				if (navbar.hasClass('scrolled')) {
					navbar.removeClass('scrolled sleep');
				}
			}
			if (st > 350) {
				if (!navbar.hasClass('awake')) {
					navbar.addClass('awake');
				}

				if (sd.length > 0) {
					sd.addClass('sleep');
				}
			}
			if (st < 350) {
				if (navbar.hasClass('awake')) {
					navbar.removeClass('awake');
					navbar.addClass('sleep');
				}
				if (sd.length > 0) {
					sd.removeClass('sleep');
				}
			}
		});
	};
	scrollWindow();


	var counter = function () {

		$('#section-counter').waypoint(function (direction) {

			if (direction === 'down' && !$(this.element).hasClass('ftco-animated')) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.number').each(function () {
					var $this = $(this),
						num = $this.data('number');
					console.log(num);
					$this.animateNumber(
						{
							number: num,
							numberStep: comma_separator_number_step
						}, 7000
					);
				});

			}

		}, { offset: '95%' });

	}
	counter();

	var contentWayPoint = function () {
		var i = 0;
		$('.ftco-animate').waypoint(function (direction) {

			if (direction === 'down' && !$(this.element).hasClass('ftco-animated')) {

				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function () {

					$('body .ftco-animate.item-animate').each(function (k) {
						var el = $(this);
						setTimeout(function () {
							var effect = el.data('animate-effect');
							if (effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if (effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if (effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						}, k * 50, 'easeInOutExpo');
					});

				}, 100);

			}

		}, { offset: '95%' });
	};
	contentWayPoint();


	// navigation
	var OnePageNav = function () {
		$(".smoothscroll[href^='#'], #ftco-nav ul li a[href^='#']").on('click', function (e) {
			e.preventDefault();

			var hash = this.hash,
				navToggler = $('.navbar-toggler');
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 700, 'easeInOutExpo', function () {
				window.location.hash = hash;
			});


			if (navToggler.is(':visible')) {
				navToggler.click();
			}
		});
		$('body').on('activate.bs.scrollspy', function () {
			console.log('nice');
		})
	};
	OnePageNav();


	// magnific popup
	$('.image-popup').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});

	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,

		fixedContentPos: false
	});



	var goHere = function () {

		$('.mouse-icon').on('click', function (event) {

			event.preventDefault();

			$('html,body').animate({
				scrollTop: $('.goto-here').offset().top
			}, 500, 'easeInOutExpo');

			return false;
		});
	};
	goHere();


	function makeTimer() {

		var date = new Date();
		var endTime = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 3);
		endTime = (Date.parse(endTime) / 1000);

		var now = new Date();
		now = (Date.parse(now) / 1000);

		var timeLeft = endTime - now;

		var days = Math.floor(timeLeft / 86400);
		var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
		var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
		var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

		if (hours < "10") { hours = "0" + hours; }
		if (minutes < "10") { minutes = "0" + minutes; }
		if (seconds < "10") { seconds = "0" + seconds; }

		$("#days").html(days + "<span>Days</span>");
		$("#hours").html(hours + "<span>Hours</span>");
		$("#minutes").html(minutes + "<span>Minutes</span>");
		$("#seconds").html(seconds + "<span>Seconds</span>");

	}
	setInterval(function () { makeTimer(); }, 1000);
})(jQuery);

function updateAge(val) {
	$("#ageValue").html(val);
}


$("#editEmail").click(function (event) {
	event.preventDefault();
	if ($(this).text() == 'Cancel') {
		$("#saveEmail").fadeOut(200);
		$("#updateEmail").prop("disabled", true);
		$(this).text('Edit');
	} else {
		$("#updateEmail").prop("disabled", false);
		$(this).text('Cancel');
		$("#saveEmail").fadeIn(200);
	}
});

$("#editPassword").click(function (event) {
	event.preventDefault();
	if ($(this).text() == 'Cancel') {
		$("#savePassword").fadeOut(200);
		$("#updatePassword").prop("disabled", true);
		$(this).text('Change Password');
	} else {
		$("#updatePassword").prop("disabled", false);
		$(this).text('Cancel');
		$("#savePassword").fadeIn(200);
	}
});

$("#ora").on('load', function () {
	width = $("#ora").width();
	height = $("#ora").height();
	tallAndNarrow = width / height < 1;
	if (tallAndNarrow) {
		$("#ora").addClass('tallAndNarrow');
	}
	$("#ora").addClass('loaded');
}).each(function () {
	if (this.complete) $(this).load();
});


$("#loginForm").on('submit', function () {
	var emailId = $("#emailId").val();
	var password = $("#password").val();
	if (emailId != "" && password != "") {
		$.ajax({
			url: 'login.php',
			type: 'post',
			data: { emailId: emailId, password: password },
			beforeSend: function () {
				$("#registering").html("<img src=images/loader.gif>");
			},
			success: function (data) {
				var msg = "";
				if (data.includes("success")) {
					switch (data) {
						case "successC":
							window.location = 'dashboard.php';
							break;
						case "successT":
							window.location = 'trader.php';
							break;
						case "successA":
							window.location = 'dashboard.php';
							break;
					}
				} else {
					if (data == "fail_email") {
						msg = "<span>The email you entered is incorrect!</span>";
					} else if (data == "fail_pass") {
						msg = "<span>The password you entered is incorrect!</span>";
					} else if (data == "not_verified") {
						msg = "<span>Your account is not verified!<br>Please verify your account using the link sent to your email.</span>";
					}
					$("#registering").html('<div class="toast" data-autohide="false" id="wrong_email"><div class="toast-header"><strong> Alert!</strong><button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button></div ><div class="toast-body" style="text-align:left" id="error">' + msg + '</div></div > ');
					$("#wrong_email").toast('show');
				}

			}
		});
	}
	return false;
});


$("#registerForm").submit(function () {
	$("#registerBtn").hide();
	var first_name = $("#first_name").val();
	var last_name = $("#last_name").val();
	var registerEmail = $("#registerEmail").val();
	var registerPassword = $("#registerPassword").val();
	var username = $("#username").val();
	var age = $("#age").val();
	var phone = $("#phone").val();
	$.ajax({
		url: 'register.php',
		type: 'post',
		data: { first_name: first_name, last_name: last_name, phone: phone, registerEmail: registerEmail, registerPassword: registerPassword, username: username, age: age },
		beforeSend: function () {
			$("#registering").html("<img src=images/loader.gif>");
		},
		success: function (data) {
			var msg = "";
			switch (data) {
				case "success":
					msg = "<span>Account registered. Please check your email for an activation link to your account.</span>";
					break;

				case "email_exists":
					msg = "<span>An account with this email address already exists!</span>";
					break;

				case "password":
					msg = "<span>Your Password must be of length 8 and contain at least 1 symbol,1 uppercase letter and 1 number without spaces!</span>";
					break;

				case "username":
					msg = "<span>Your username must be of min. length 6 and can only contain lowercase letters ,numbers & underscores!</span>";
					break;

				case "username_exists":
					msg = "<span>Username already taken. Please try another!</span>";
					break;

				case "email":
					msg = "<span>Please enter a valid email!</span>";
					break;

				case "firstname":
					msg = "<span>First Name must contain only letters!</span>";
					break;

				case "lastname":
					msg = "<span>Last Name must contain letters only!</span>";
					break;
			}
			$("#registering").html('<div class="toast" data-autohide="false" id="wrong_email"><div class="toast-header"><strong> Alert!</strong><button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button></div ><div class="toast-body" style="text-align:left" id="error">' + msg + '</div></div > ');
			$("#wrong_email").toast('show');
			$("#registerBtn").show();
		}
	});
	return false;
});

$('#phone').keyup(function () {
	$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
});

$('a[data-toggle="tab"]').on('show.bs.tab', function () {
	$("#wrong_email").toast('hide');
});

$(document).ready(function () {

	if (!localStorage.getItem('collapseItem'))
		localStorage.setItem('collapseItem', '#' + $('#profileUpdate').attr('id'));


	$('#profileUpdate').on('shown.bs.collapse', function () {
		localStorage.setItem('collapseItem', '#' + $(this).attr('id'));
		var collapseItem = localStorage.getItem('collapseItem');
		$('.btn-accord').removeClass('active');
		$(collapseItem + 'Btn').addClass('active');
	});

	$('#shopManage').on('shown.bs.collapse', function () {
		localStorage.setItem('collapseItem', '#' + $(this).attr('id'));
		var collapseItem = localStorage.getItem('collapseItem');
		$('.btn-accord').removeClass('active');
		$(collapseItem + 'Btn').addClass('active');
	});

	$('#addProduct').on('shown.bs.collapse', function () {
		localStorage.setItem('collapseItem', '#' + $(this).attr('id'));
		var collapseItem = localStorage.getItem('collapseItem');
		$('.btn-accord').removeClass('active');
		$(collapseItem + 'Btn').addClass('active');
	});

	$('#manageProduct').on('shown.bs.collapse', function () {
		localStorage.setItem('collapseItem', '#' + $(this).attr('id'));
		var collapseItem = localStorage.getItem('collapseItem');
		$('.btn-accord').removeClass('active');
		$(collapseItem + 'Btn').addClass('active');
	});

	var collapseItem = localStorage.getItem('collapseItem');
	$(collapseItem).collapse('show');
});



$(document).ready(function () {

	if ($('body.dashboard').length > 0) {

		if ($('#image_upload').hasClass("trader")) {
			$image_crop = $("#img-demo").croppie({
				enableExif: true,
				viewport: {
					width: 200,
					height: 200,
					type: 'square'
				},
				boundary: {
					width: 300,
					height: 300
				}
			});
		} else {
			$image_crop = $("#img-demo").croppie({
				enableExif: true,
				viewport: {
					width: 200,
					height: 200,
					type: 'circle'
				},
				boundary: {
					width: 300,
					height: 300
				}
			});
		}

		$product_img = $('#product-img-demo').croppie({
			enableExif: true,
			viewport: {
				width: 250,
				height: 200,
				type: 'square'
			},
			boundary: {
				width: 300,
				height: 300
			}

		});

		$('#product-image').on('change', function () {
			var reader = new FileReader();
			reader.onload = function (event) {
				$product_img.croppie('bind', {
					url: event.target.result
				}).then(function () {
					console.log('jquery bin complete product');
				});
			}
			reader.readAsDataURL(this.files[0]);
			$("#uploadProductModal").modal('show');
		});


		$('#cropProduct').click(function (event) {
			$product_img.croppie('result', {
				type: 'canvas',
				size: { width: 1000, height: 800 },
			}).then(function (response) {
				$.ajax({
					url: "upload.php",
					type: "POST",
					data: { "product-image": response },
					success: function (data) {
						$('#uploadProductModal').modal('hide');
						$('.product-pic').attr('src', data);
					}
				});
			})
		});

		$('#image_upload').on('change', function () {
			var reader = new FileReader();
			reader.onload = function (event) {
				$image_crop.croppie('bind', {
					url: event.target.result
				}).then(function () {
					console.log('jquery bind complete');
				});
			}
			reader.readAsDataURL(this.files[0]);
			$("#uploadImageModal").modal('show');
		});
		$('#crop').click(function (event) {
			$image_crop.croppie('result', {
				type: 'canvas',
				size: 'viewport'
			}).then(function (response) {
				$.ajax({
					url: "upload.php",
					type: "POST",
					data: { "image_upload": response },
					success: function (data) {
						$('#uploadImageModal').modal('hide');
						$('.profilepic').attr('src', data);
					}
				});
			})
		});
	}
});



// the current open accordion will not be able to close itself
$('[data-toggle="collapse"]').on('click', function (e) {
	if ($(this).parents('.accordion').find('.collapse.show')) {
		var idx = $(this).index('[data-toggle="collapse"]');
		if (idx == $('.collapse.show').index('.collapse')) {
			e.stopPropagation();
		}
	}
});

//pagination
$(document).ready(function () {

	if (!localStorage.getItem('pageNum'))
		load_data(1);
	else
		load_data(localStorage.getItem('pageNum'));

	function load_data(page) {
		$.ajax({
			url: 'products.php',
			method: 'GET',
			data: { page: page },
			success: function (data) {
				$('#products').html(data);
			}
		})
	}

	$(document).on('click', '.pag_link', function () {
		page = $(this).children('a').attr("id");
		localStorage.setItem('pageNum', page);
		load_data(page);
	});

});

$('.page-link-bs').click(function() {
	var page = $(this).html();
	
	if(page)



});


$(document).ready(function () {

	$('.quantity-right-plus').mousedown(function (e) {

		// Stop acting like a button
		e.preventDefault();

		// Get the field name
		var quantity = parseInt($('#quantity').val());
		timeout = setInterval(function () {
			if (quantity + 1 <= $('#quantity').attr('max'))
				$('#quantity').val(++quantity);
		}, 500);

	});

	$('.quantity-right-plus').click(function (e) {

		// Stop acting like a button
		e.preventDefault();

		// Get the field name
		var quantity = parseInt($('#quantity').val());

		if (quantity + 1 <= $('#quantity').attr('max'))
			$('#quantity').val(++quantity);
	});

	$('.quantity-left-minus').mousedown(function (e) {
		// Stop acting like a button
		e.preventDefault();
		// Get the field name
		var quantity = parseInt($('#quantity').val());
		timeout = setInterval(function () {
			if (quantity - 1 >= $('#quantity').attr('min'))
				$('#quantity').val(--quantity);
		}, 500);
	});

	$('.quantity-left-minus').click(function (e) {

		// Stop acting like a button
		e.preventDefault();

		// Get the field name
		var quantity = parseInt($('#quantity').val());

		if (quantity - 1 >= $('#quantity').attr('min'))
			$('#quantity').val(--quantity);
	});


	$('.btn-number').mouseup(function () {
		clearInterval(timeout);
		return false;
	});

	$('.btn-number').mouseout(function () {
		clearInterval(timeout);
		return false;
	});

});

$('#resetBtn').click(function () {
	$('.product-pic').attr('src', "images/product-demo.png");
});

$('#addProduct').submit(function (e) {
	e.preventDefault();
	if (!$('#shop-id').val()) {
		$('#errorInfo').html('<div class="toast mt-n4 mb-4" data-autohide="false" id="wrong_email"><div class="toast-header"><strong style="color:#f76666"> Alert!</strong><button type="button" class="close" data-dismiss="toast">&times;</button></div><div class="toast-body" style="text-align:left" id="aerror">Please select the shop.</div></div>');
		$('#wrong_email').toast('show');
	} else if (!$('#unit').val()) {
		$('#errorInfo').html('<div class="toast mt-n4 mb-4" data-autohide="false" id="wrong_email"><div class="toast-header"><strong style="color:#f76666"> Alert!</strong><button type="button" class="close" data-dismiss="toast">&times;</button></div><div class="toast-body" style="text-align:left" id="aerror">Please select the quantity unit.</div></div>');
		$('#wrong_email').toast('show');
	} else {
		var pname = $('#product-name').val();
		var price = parseFloat($('#product-price').val())
		var pshop = $('#shop-id').val();
		var quantity = parseInt($('#quanPerItem').val()) + ' ' + $('#unit').val();
		var allergy = $('#allergy').val();
		var min = parseInt($('#min-order').val());
		var max = parseInt($('#max-order').val());
		var stock = parseInt($('#stock-amount').val());
		var description = $('textarea#description').val();
		var pimg = $('.product-pic').attr('src');


		$.ajax({
			url: 'addProduct.php',
			method: 'GET',
			data: { pname: pname, price: price, pshop: pshop, quantity: quantity, allergy: allergy, min: min, max: max, stock: stock, description: description, pimg: pimg },
			success: function (response) {
				var msg = response;
				if (msg == "all") {
					$('#errorInfo').html('<div class="toast mt-n4 mb-4" data-autohide="false" id="wrong_email"><div class="toast-header"><strong style="color:#f76666"> Alert!</strong><button type="button" class="close" data-dismiss="toast">&times;</button></div><div class="toast-body" style="text-align:left" id="aerror">Please select all fields.</div></div>');
					$('#wrong_email').toast('show');
				}
				else if (msg == "exist") {
					$('#errorInfo').html('<div class="toast mt-n4 mb-4" data-autohide="false" id="wrong_email"><div class="toast-header"><strong style="color:#f76666"> Success!</strong><button type="button" class="close" data-dismiss="toast">&times;</button></div><div class="toast-body" style="text-align:left" id="aerror">Product already exists in this shop.</div></div>');
					$('#wrong_email').toast('show');
				}

				else {
					$('#errorInfo').html('<div class="toast mt-n4 mb-4" data-autohide="false" id="wrong_email"><div class="toast-header"><strong style="color:#82aef6"> Success!</strong><button type="button" class="close" data-dismiss="toast">&times;</button></div><div class="toast-body" style="text-align:left" id="aerror">Successfully Inserted Product</div></div>');
					$('#wrong_email').toast('show');
				}
			}
		});
	}


});
