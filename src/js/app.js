/* globals $:false */
var width = $(window).width(),
    height = $(window).height(),
    isMobile = false,
    target,
    lastTarget = false,
    slider,
    $mouseNav,
    $root = '/';
$(function() {
    var app = {
        init: function() {
            console.log('Code by Tristan Bagot', 'www.tristanbagot.com');
            $(window).resize(function(event) {
                app.sizeSet();
            });
            $(document).ready(function($) {
                $body = $('body');
                $container = $('#container');
                app.interact();
                app.smoothState('#main', $container);
                // window.viewportUnitsBuggyfill.init();
                $(document).keyup(function(e) {
                    //esc
                    if (e.keyCode === 27) app.goBack();
                    if (slider && e.keyCode === 39) slider.next();
                    if (slider && e.keyCode === 37) slider.previous();
                });
                $(window).load(function() {
                    $(".loader").click(function(event) {
                        $(this).addClass('animate');
                        setTimeout(function() {
                            $(".loader").remove();
                        }, 2000);
                    });
                });
            });
        },
        sizeSet: function() {
            width = $(window).width();
            height = $(window).height();
            if (width <= 770) isMobile = true;
            if (isMobile) {
                if (width >= 770) {
                    //location.reload();
                    isMobile = false;
                }
            }
        },
        interact: function() {
            app.loadSlider();
            app.imagesScroll();
            app.searchBar();
            $("#menu-burger").click(function(event) {
                if ($(this).hasClass('open')) {
                    $(this).removeClass('open');
                    $("nav.categories").removeClass('open');
                } else {
                    $(this).addClass('open');
                    $("nav.categories").addClass('open');
                }
            });
            $("[event-target='additional-menu']").click(function(event) {
                if ($("nav.categories").hasClass('more')) {
                    $("nav.categories, #additional-menu").removeClass('more');
                    $body.css('overflow','auto');
                } else {
                    $("nav.categories, #additional-menu").addClass('more');
                    $body.css('overflow','hidden');
                }
            });
        },
        searchBar: function() {
            var $form = $('#search:not(.no-ajax)');
            if ($form.length > 0) {
                var searchUrl = $form.attr('action');
                $form.keydown(function(event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
                $form.find('input').keyup(debounce(function(event) {
                    doSearch(searchUrl, $(this).val(), "#medias", function() {});
                }, 400));
            }
        },
        imagesScroll: function() {
            var head = 45 + 34;
            var $cover = $(".post-cover");

            function checkTagPosition() {
                currentScroll = $(window).scrollTop();
                $cover.hide();
                $('figcaption[data-scroll]').each(function(index, el) {
                    $el = $(el);
                    calc = currentScroll + head - $el.offset().top;
                    console.log(index, calc);
                    if (calc < 0) {
                        $('img[data-scroll="' + $el.data('scroll') + '"]').prev('img').show();
                    } else {
                        $('img[data-scroll="' + $el.data('scroll') + '"]').prev('img').hide();
                    }
                });
            }
            $(window).unbind('scroll');
            requestId = null;
            if (typeof document.getElementById("post-visuals") !== "undefined") {
                $postVisuals = $("#post-visuals");
                $cover.click(function(event) {
                    $(this).hide();
                });
                $('figure[data-scroll]').each(function(index, el) {
                    id = el.getAttribute("data-scroll");
                    img = $(el).find("img").css('z-index', 500 - index).attr('data-scroll', id);
                    $postVisuals.append(img);
                });
                requestId = null;
                $(window).scroll(function(event) {
                    requestId = window.requestAnimationFrame(checkTagPosition);
                });
            }
        },
        plyr: function(loop) {
            players = plyr.setup('.js-player', {
                loop: false,
                controls: ['controls', 'progress'],
                iconUrl: $root + "/assets/css/plyr/plyr.svg"
            });
            for (var i = players.length - 1; i >= 0; i--) {
                players[i].on('play', function(event) {
                    slider.element.classList.remove('play')
                    slider.element.classList.add('pause');
                });
                players[i].on('pause', function(event) {
                    slider.element.classList.remove('pause')
                    slider.element.classList.add('play');
                });
                players[i].on('waiting', function(event) {
                    slider.element.classList.add('loading');
                });
                players[i].on('canplay', function(event) {
                    slider.element.classList.remove('loading');
                });
                players[i].on('ready', function(event) {
                    $(".plyr__controls").hover(function() {
                        $mouseNav.css('visibility', 'hidden');
                    }, function() {
                        $mouseNav.css('visibility', 'visible');
                    });
                });
            }
        },
        loadSlider: function() {
            $mouseNav = $('#mouse-nav');
            slider = document.querySelector('.slider');
            if (slider) {
                slider = new Flickity(slider, {
                    cellSelector: '.slide',
                    imagesLoaded: true,
                    lazyLoad: 2,
                    setGallerySize: false,
                    accessibility: false,
                    wrapAround: true,
                    prevNextButtons: !isMobile,
                    pageDots: false,
                    draggable: isMobile,
                    dragThreshold: 20
                });
                app.mouseNav();
                var vids = document.querySelectorAll(".slider video");
                if (vids.length > 0) {
                    var hls = [];
                    for (var i = vids.length - 1; i >= 0; i--) {
                        vids[i].controls = false;
                        if (!isMobile && vids[i].getAttribute("data-stream") && Hls.isSupported()) {
                            hls[i] = new Hls({
                                minAutoBitrate: 1700000
                            });
                            hls[i].loadSource(vids[i].getAttribute("data-stream"));
                            hls[i].attachMedia(vids[i]);
                            vids[i].setAttribute('poster', '');
                        }
                    }
                    app.plyr();
                }
                slider.slidesCount = slider.slides.length;
                slider.element.setAttribute("data-media", slider.selectedElement.getAttribute("data-media"));
                slider.on('select', function() {
                    //$('#slide-number').html((slider.selectedIndex + 1) + '/' + slider.slidesCount);
                    slider.element.setAttribute("data-media", slider.selectedElement.getAttribute("data-media"));
                });
                slider.on('staticClick', function(event, pointer, cellElement, cellIndex) {
                    if (!cellElement || !isMobile) {
                        return;
                    } else {
                        slider.next();
                    }
                });
                if (vids.length > 0) {
                    slider.on('select', function() {
                        $.each(vids, function() {
                            this.pause();
                        });
                        slider.element.classList.remove('play', 'pause');
                    });
                    if (slider.selectedElement.getAttribute("data-media") == "video") {
                        if (typeof hls[0] !== "undefined") {
                            hls[0].on(Hls.Events.MANIFEST_PARSED, function() {
                                vids[0].play();
                            });
                        } else  {
                            vids[0].play();
                        }
                    }
                } else if (slider.slidesCount < 2) {
                    $mouseNav.remove();
                    slider.element.style.cursor = 'auto';
                }
            }
        },
        mouseNav: function() {
            $(slider.element).mousemove(function(event) {
                if (slider) {
                    var x = event.pageX;
                    var y = event.pageY;
                    if (x < width / 2) {
                        slider.element.classList.remove('right');
                        slider.element.classList.add('left');
                    } else {
                        slider.element.classList.remove('left');
                        slider.element.classList.add('right');
                    }
                    if (slider.element.getAttribute("data-media") === "video" && slider.slidesCount > 1) {
                        if (x < 0.15 * width || x > 0.85 * width) {
                            slider.element.classList.add('nav-hover');
                        } else {
                            slider.element.classList.remove('nav-hover');
                        }
                    }
                    $mouseNav.css({
                        transform: "translate(" + x + "px, " + (y - $(window).scrollTop()) + "px) translateZ(0)"
                    });
                }
            });
            $('#project-description, #project-title, .close-button a').hover(function() {
                $mouseNav.hide();
            }, function() {
                $mouseNav.show();
            });
        },
        goIndex: function() {},
        goBack: function() {
            if (window.history && history.length > 0 && !$body.hasClass('projects')) {
                window.history.go(-1);
            } else {
                $('#site-title a').click();
            }
        },
        smoothState: function(container, $target) {
            var options = {
                    debug: true,
                    scroll: true,
                    anchors: '[data-target]',
                    loadingClass: false,
                    prefetch: true,
                    cacheLength: 4,
                    onAction: function($currentTarget, $container) {
                        lastTarget = target;
                        target = $currentTarget.data('target');
                        if (target === "back") app.goBack();
                        $("#menu-burger").removeClass('open');
                        $("nav.categories").removeClass('open');
                        $("nav.categories, #additional-menu").removeClass('more');
                        $body.css('overflow','auto');
                        // console.log(lastTarget);
                    },
                    onBefore: function(request, $container) {
                        popstate = request.url.replace(/\/$/, '').replace(window.location.origin + $root, '');
                        // console.log(popstate);
                    },
                    onStart: {
                        duration: 200, // Duration of our animation
                        render: function($container) {
                            $body.addClass('is-loading');
                        }
                    },
                    onReady: {
                        duration: 0,
                        render: function($container, $newContent) {
                            // Inject the new content
                            $container.html($newContent);
                        }
                    },
                    onAfter: function($container, $newContent) {
                        //$(window).scrollTop(0);
                        app.interact();
                        smoothState.clear();
                        setTimeout(function() {
                            $body.removeClass('is-loading');
                            // Clear cache for random content
                        }, 300);
                    }
                },
                smoothState = $(container).smoothState(options).data('smoothState');
        }
    };
    app.init();
});