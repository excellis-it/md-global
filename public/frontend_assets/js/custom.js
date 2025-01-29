(function ($) {
    $.fn.menumaker = function (options) {
        var cssmenu = $(this),
            settings = $.extend(
                {
                    title: "Menu",
                    format: "dropdown",
                    sticky: false,
                },
                options
            );

        return this.each(function () {
            cssmenu.prepend(
                '<div id="menu-button">' + settings.title + "</div>"
            );
            $(this)
                .find("#menu-button")
                .on("click", function () {
                    $(this).toggleClass("menu-opened");
                    var mainmenu = $(this).next("ul");
                    if (mainmenu.hasClass("open")) {
                        mainmenu.hide().removeClass("open");
                    } else {
                        mainmenu.show().addClass("open");
                        if (settings.format === "dropdown") {
                            mainmenu.find("ul").show();
                        }
                    }
                });

            cssmenu.find("li ul").parent().addClass("has-sub");

            multiTg = function () {
                cssmenu
                    .find(".has-sub")
                    .prepend('<span class="submenu-button"></span>');
                cssmenu.find(".submenu-button").on("click", function () {
                    $(this).toggleClass("submenu-opened");
                    if ($(this).siblings("ul").hasClass("open")) {
                        $(this).siblings("ul").removeClass("open").hide();
                    } else {
                        $(this).siblings("ul").addClass("open").show();
                    }
                });
            };

            if (settings.format === "multitoggle") multiTg();
            else cssmenu.addClass("dropdown");

            if (settings.sticky === true) cssmenu.css("position", "fixed");

            resizeFix = function () {
                if ($(window).width() > 1024) {
                    cssmenu.find("ul").show();
                }

                if ($(window).width() <= 1024) {
                    cssmenu.find("ul").hide().removeClass("open");
                }
            };
            resizeFix();
            return $(window).on("resize", resizeFix);
        });
    };
})(jQuery);

(function ($) {
    $(document).ready(function () {
        $("#cssmenu").menumaker({
            title: "",
            format: "multitoggle",
        });
    });
})(jQuery);

/*----- slier --------*/

$(".slider").slick({
    autoplay: true,
    speed: 2000,
    lazyLoad: "progressive",
    arrows: false,
    dots: true,
    fade: true,
    prevArrow:
        '<div class="slick-nav prev-arrow"><i class="fa fa-arrow-left"></i></div>',
    nextArrow:
        '<div class="slick-nav next-arrow"><i class="fa fa-arrow-right"></i></div>',
    responsive: [
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
            },
        },
    ],
});

$(".slick-nav").on("click touch", function (e) {
    e.preventDefault();

    var arrow = $(this);

    if (!arrow.hasClass("animate")) {
        arrow.addClass("animate");
        setTimeout(() => {
            arrow.removeClass("animate");
        }, 2000);
    }
});
/*----- slier --------*/

$(".wht-serv").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 2000,
    autoplay: false,
    prevArrow:
        '<div class="slick-nav prev-arrow"><i class="fa fa-arrow-left"></i></div>',
    nextArrow:
        '<div class="slick-nav next-arrow"><i class="fa fa-arrow-right"></i></div>',
    responsive: [
        {
            breakpoint: 999,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        {
            breakpoint: 799,
            settings: {
                arrows: false,
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ],
});


$(".services_slid").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 2000,
    autoplay: false,
    prevArrow:
        '<div class="slick-nav prev-arrow"><i class="fa fa-arrow-left"></i></div>',
    nextArrow:
        '<div class="slick-nav next-arrow"><i class="fa fa-arrow-right"></i></div>',
    responsive: [
        {
            breakpoint: 999,
            settings: {
                arrows: false,
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 799,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ],
});



$(".blog_slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 2000,
    autoplay: false,
    prevArrow:
        '<div class="slick-nav prev-arrow"><i class="fa fa-arrow-left"></i></div>',
    nextArrow:
        '<div class="slick-nav next-arrow"><i class="fa fa-arrow-right"></i></div>',
    responsive: [
        {
            breakpoint: 999,
            settings: {
                arrows: false,
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 799,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ],
});





$(".test-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    centerMode: true,
    arrows: false,
    dots: true,
    speed: 300,
    centerPadding: "0px",
    infinite: true,
    autoplaySpeed: 2000,
    autoplay: false,
    prevArrow:
        '<div class="slick-nav prev-arrow"><i class="fa-solid fa-arrow-left"></i></div>',
    nextArrow:
        '<div class="slick-nav next-arrow"><i class="fa-solid fa-arrow-right"></i></div>',
    responsive: [
        {
            breakpoint: 800,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: "0px",
                slidesToShow: 1,
            },
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: "0px",
                slidesToShow: 1,
            },
        },
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ],
});

$(".app-doc-wrap").slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 2000,
    autoplay: true,
    prevArrow:
        '<div class="slick-nav prev-arrow"><i class="fa fa-arrow-left"></i></div>',
    nextArrow:
        '<div class="slick-nav next-arrow"><i class="fa fa-arrow-right"></i></div>',
    responsive: [
        {
            breakpoint: 1500,
            settings: {
                arrows: false,
                slidesToShow: 4,
            },
        },
        {
            breakpoint: 1450,
            settings: {
                arrows: false,
                slidesToShow: 3,
            },
        },
        {
            breakpoint: 1200,
            settings: {
                arrows: false,
                slidesToShow: 3,
            },
        },
        {
            breakpoint: 992,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        {
            breakpoint: 799,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        {
            breakpoint: 800,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                slidesToShow: 1,
            },
        },
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ],
});

AOS.init();

/*----- slier --------*/

$(".circle_percent").each(function () {
    var $this = $(this),
        $dataV = $this.data("percent"),
        $dataDeg = $dataV * 3.6,
        $round = $this.find(".round_per");
    $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
    $this.append(
        '<div class="circle_inbox"><span class="percent_text"></span></div>'
    );
    $this.prop("Counter", 0).animate(
        { Counter: $dataV },
        {
            duration: 2000,
            easing: "swing",
            step: function (now) {
                $this.find(".percent_text").text(Math.ceil(now) + "%");
            },
        }
    );
    if ($dataV >= 51) {
        $round.css("transform", "rotate(" + 360 + "deg)");
        setTimeout(function () {
            $this.addClass("percent_more");
        }, 1000);
        setTimeout(function () {
            $round.css(
                "transform",
                "rotate(" + parseInt($dataDeg + 180) + "deg)"
            );
        }, 1000);
    }
});

// function openNav() {
//     document.getElementById("mySidenav").style.width = "100%";
// }

// function closeNav() {
//     document.getElementById("mySidenav").style.width = "0";
// }

// scroll top

var $btnTop = $("#scrl");
$(window).on("scroll", function () {
    if ($(window).scrollTop() >= 20) {
        $btnTop.fadeIn();
    } else {
        $btnTop.fadeOut();
    }
});

$btnTop.on("click", function () {
    $("html, body").animate({ scrollTop: 0 }, 300);
});

AOS.init({
    disable: function () {
        var maxWidth = 800;
        return window.innerWidth < maxWidth;
    },
});

document.addEventListener("DOMContentLoaded", function (event) {
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);

        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener("click", () => {
                // show navbar
                nav.classList.toggle("show");
                // change icon
                toggle.classList.toggle("bx-x");
                // add padding to body
                bodypd.classList.toggle("body-pd");
                // add padding to header
                headerpd.classList.toggle("body-pd");
            });
        }
    };

    showNavbar("header-toggle", "nav-bar", "body-pd", "header");

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll(".nav_link");

    function colorLink() {
        if (linkColor) {
            linkColor.forEach((l) => l.classList.remove("active"));
            this.classList.add("active");
        }
    }
    linkColor.forEach((l) => l.addEventListener("click", colorLink));

    // Your code to run since DOM is loaded and ready
});
