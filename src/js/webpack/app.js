/* jshint esversion: 6 */

import lazysizes from 'lazysizes';
import Flickity from 'flickity';
import throttle from 'lodash.throttle';
import debounce from 'lodash.debounce';
import Barba from 'barba.js';
import TweenMax from 'gsap';
import 'gsap/MorphSVGPlugin';

const freezeVp = (e) => {
  e.preventDefault();
};

const stopBodyScrolling = (bool) => {
  if (bool === true) {
    document.body.addEventListener("touchmove", freezeVp, false);
  } else {
    document.body.removeEventListener("touchmove", freezeVp, false);
  }
};

const App = {
  introTl: null,
  pageType: null,
  body: null,
  width: null,
  height: null,
  container: null,
  header: null,
  headerHeight: null,
  menuBurger: null,
  categories: null,
  isMobile: null,
  initialize: () => {
    console.log('Concept & design:', 'Emmanuel Crivelli', 'www.dualroom.ch');
    console.log('Website development:', 'Tristan Bagot', 'www.tristanbagot.com');
    App.body = document.body;
    App.pageType = App.body.getAttribute('page-type');
    App.header = document.querySelector("header");
    App.categories = document.getElementById("main-categories");
    App.container = document.getElementById("main");
    App.sizeSet();
    App.pjax();
    App.intro.init();
    App.interact.init();
    document.addEventListener('lazybeforeunveil', function(e) {
      if (e.target.classList.contains('lazycontainer'))
        e.target.parentNode.classList.add('lazyloaded');
    });
    require('viewport-units-buggyfill').init();
    window.addEventListener('resize', debounce(App.sizeSet, 128), false);
    TweenMax.to('#loader', 0.2, {
      autoAlpha: 0
    });
  },
  sizeSet: () => {
    App.width = window.innerWidth;
    App.height = window.innerHeight;
    App.headerHeight = App.header.offsetHeight;
    if (App.width <= 1024)
      App.isMobile = true;
    if (App.isMobile) {
      if (App.width >= 1024) {
        location.reload();
        App.isMobile = false;
      }
    }
  },
  intro: {
    element: null,
    init: () => {
      App.intro.element = document.getElementById('intro');
      if (App.intro.element) {
        stopBodyScrolling(true);
        const timing = 3;
        App.introTl = new TimelineMax({
          paused: true,
          repeat: -1,
          yoyo: true
        });
        App.introTl.to('#h-square', timing, {
          morphSVG: {
            shape: '#h-rounded',
            shapeIndex: 0
          },
          ease: Expo.easeInOut
        }).to('#i-square', timing, {
          morphSVG: {
            shape: '#i-rounded',
            shapeIndex: 0
          },
          ease: Expo.easeInOut
        }, '-=' + timing).to('#qm-square', timing, {
          morphSVG: {
            shape: '#qm-rounded',
            shapeIndex: 0
          },
          ease: Expo.easeInOut
        }, '-=' + timing).to('#p-square', timing, {
          morphSVG: {
            shape: '#p-rounded',
            shapeIndex: 0
          },
          ease: Expo.easeInOut
        }, '-=' + timing);
        App.introTl.play();

        App.intro.element.addEventListener('click', App.intro.hide);
      }
    },
    hide: () => {
      if (App.intro.element) {
        if (App.isMobile) {
          App.intro.destroy();
          return;
        }
        const tl = new TimelineMax({
          onComplete: App.intro.destroy
        });
        tl.staggerTo('#square path', 1, {
          y: -App.height * 1.5,
          ease: Expo.easeInOut
        }, 0.15).to(intro, 0.8, {
          yPercent: -100,
          ease: Expo.easeInOut
        }, '-=0.6');
      }
    },
    destroy: () => {
      if (App.intro.element) {
        App.body.classList.remove('with-intro');
        stopBodyScrolling(false);
        App.intro.element.parentNode.removeChild(App.intro.element);
        App.introTl.kill();
        App.intro.element = null;
      }
    }
  },
  interact: {
    init: () => {
      App.linkTargets();
      App.embedKirby();
      App.interact.enteringAnimations();
      App.thumbnailSliders();
      App.interact.imagesScroll();
      App.interact.eventTargets();
    },
    eventTargets: () => {
      App.interact.menuBurger();
      App.interact.filters();
      window.addEventListener("keydown", function(event) {
        if (event.defaultPrevented) return;
        if (App.menuOn && event.key === "Escape") {
          App.body.classList.remove('menu-on', 'more-on')
          App.menuOn = false;
        }
      });
    },
    enteringAnimations: () => {
      if (App.pageType == 'info') {
        setTimeout(function() {
          TweenMax.staggerFromTo('.huge, .social', 1, {
            y: App.height,
            visibility: 'visible'
          }, {
            y: 0,
            force3D: true,
            ease: Expo.easeOut
          }, 0.5);
        }, 350);
      }
    },
    imagesScroll: () => {
      const cover = document.getElementById('post-cover');
      let coverHidden = false;
      const postVisuals = document.getElementById('post-visuals');
      const figcaptions = document.querySelectorAll('figcaption[data-scroll]');
      const figures = document.querySelectorAll('figure[data-scroll]');

      const startScroll = () => {
        postVisuals.classList.add('is-scrolling');
      };
      const stopScroll = () => {
        postVisuals.classList.remove('is-scrolling');
      };

      const checkTagPosition = (event, first = false) => {
        if (cover && !coverHidden && !first) {
          cover.style.display = 'none';
          coverHidden = true;
        }
        if (!App.isMobile) {
          let noTagFound = true;
          if (App.headerHeight - figures[0].getBoundingClientRect().top < 0) {
            postVisuals.setAttribute('image-index', 1);
            return;
          }
          figures.forEach(function(el, index) {
            const touchTop = App.headerHeight - el.getBoundingClientRect().top;
            const touchBottom = App.headerHeight - el.getBoundingClientRect().bottom;
            if (touchTop >= 0) {
              postVisuals.setAttribute('image-index', (index + 1));
              if (touchBottom < 0) {
                postVisuals.classList.add('current-tag');
                noTagFound = false;
              }
            }
            if (noTagFound) {
              postVisuals.classList.remove('current-tag');
            }
          });
        }
      };
      if (postVisuals) {
        if (cover) {
          cover.addEventListener('click', (e) => {
            cover.style.display = "none";
            coverHidden = true;
          });
        }
        if (!App.isMobile) {
          figures.forEach(function(el, index) {
            const id = el.getAttribute("data-scroll");
            const img = el.querySelector("img");

            const imgContainer = document.createElement('div');
            imgContainer.className = 'post-visual';
            imgContainer.appendChild(img);
            imgContainer.style.zIndex = 500 - index;
            imgContainer.setAttribute('data-scroll', id);

            if (img.getAttribute('data-credits')) {
              const credits = document.createElement('div');
              credits.className = 'credits';
              credits.innerHTML = img.getAttribute('data-credits');
              imgContainer.appendChild(credits);
            }

            postVisuals.appendChild(imgContainer);
          });
          window.addEventListener('scroll', throttle(startScroll, 128), false);
          window.addEventListener('scroll', debounce(stopScroll, 128), false);
        }
        window.addEventListener('scroll', throttle(checkTagPosition, 128), false);
        checkTagPosition(null, true);

      }
    },
    filters: () => {
      let filtersOn = false;
      let filtering = false;
      const resultsBar = document.getElementById('results-bar');
      const toggleFilters = document.getElementById('toggle-filters');
      if (!resultsBar || !toggleFilters) return;

      const clearFilters = document.getElementById('clear-filters');
      const filterButtons = resultsBar.querySelectorAll('[data-filter]');

      const filterCategory = (filter) => {
        const medias = document.getElementsByClassName('media');

        for (var i = 0; i < medias.length; i++) {
          const el = medias[i];
          if (el.getAttribute('data-filter') == filter) {
            el.style.display = 'block';
          } else {
            el.style.display = 'none';
          }
        }
      };
      const hideFilters = () => {
        resultsBar.classList.remove('show-filters');
        filtersOn = false;
      };
      const unselectFilters = () => {
        for (var i = 0; i < filterButtons.length; i++) {
          filterButtons[i].classList.remove('active');
        }
      };
      const unselectMedias = () => {
        const medias = document.getElementsByClassName('media');
        for (var i = 0; i < medias.length; i++) medias[i].style.display = 'block';
      };
      const resetFilters = () => {
        unselectFilters();
        unselectMedias();
        filtering = false;
      };

      filterButtons.forEach((el) => {
        el.addEventListener('click', (e) => {
          filtering = e.currentTarget.getAttribute('data-filter');
          unselectFilters();
          e.currentTarget.classList.add('active');
          resultsBar.classList.remove('show-filters');
          filtersOn = false;
          filterCategory(filtering);

        });
      });

      toggleFilters.addEventListener('click', () => {
        if (!filtersOn && !filtering) {
          TweenMax.staggerFromTo('span[data-filter]', 0.7, {
            yPercent: 110,
            visibility: 'visible'
          }, {
            yPercent: 0,
            force3D: true,
            ease: Expo.easeOut
          }, 0.2);
          resultsBar.classList.add('show-filters');
          filtersOn = !filtersOn;
        }
      });

      clearFilters.addEventListener('click', () => {
        if (filtering) {
          TweenMax.fromTo('span[data-filter].active', 0.5, {
            yPercent: 0
          }, {
            yPercent: -110,
            force3D: true,
            ease: Expo.easeIn,
            onComplete: resetFilters
          });
        } else {
          TweenMax.staggerFromTo('span[data-filter]', 0.5, {
            yPercent: 0,
            visibility: 'visible'
          }, {
            yPercent: -110,
            force3D: true,
            ease: Expo.easeIn
          }, -0.2, hideFilters);

        }
      });
    },
    menuBurger: () => {
      App.menuOn = false;

      const moreButtons = document.querySelectorAll('[event-target=additional-menu]');
      const menuButtons = document.querySelectorAll('[event-target=menu]');
      const menuCategories = document.querySelectorAll('.search-category');

      moreButtons.forEach((el) => {
        el.addEventListener('click', () => {
          App.body.classList.toggle('more-on');
        });
      });

      menuButtons.forEach((el) => {
        el.addEventListener('click', () => {
          if (App.menuOn && App.isMobile) {
            App.body.classList.remove('menu-on', 'more-on', 'category-active');
            menuCategories.forEach((el) => {
              el.classList.remove('active');
            });
            App.menuOn = false;
            return;
          }
          if (!App.menuOn) {
            const targets = App.isMobile ? '#main-categories li, #close-menu' : '#main-categories li';
            TweenMax.staggerFromTo(targets, 0.8, {
              y: App.height
            }, {
              y: 0,
              force3D: true,
              ease: Expo.easeInOut
            }, 0.25);
          }
          App.body.classList.toggle('menu-on');
          App.menuOn = !App.menuOn;
        });
      });

      menuCategories.forEach((el) => {
        el.addEventListener('click', (e) => {
          if (el.classList.contains('active')) {
            el.classList.remove('active');
            App.body.classList.remove('category-active');
          } else {
            el.classList.add('active');
            App.body.classList.add('category-active');
          }
        });
      });
    }
  },
  linkTargets: () => {
    document.querySelectorAll("a").forEach(function(element, index) {
      if (element.host !== window.location.host) {
        element.setAttribute('target', '_blank');
      } else {
        element.setAttribute('data-target', 'page');
      }
    });
  },
  embedKirby: () => {
    var pluginEmbedLoadLazyVideo = function() {
      var wrapper = this.parentNode;
      var embed = wrapper.children[0];
      embed.src = embed.dataset.src;
      wrapper.removeChild(this);
    };

    var thumb = document.getElementsByClassName('embed__thumb');

    for (var i = 0; i < thumb.length; i++) {
      thumb[i].addEventListener('click', pluginEmbedLoadLazyVideo, false);
    }
  },
  // loadSliders: () => {
  //   const initFlickity = (element) => {
  //     let slider = new Flickity(element, {
  //       cellSelector: '.slide',
  //       imagesLoaded: true,
  //       lazyLoad: 1,
  //       setGallerySize: true,
  //       adaptiveHeight: true,
  //       percentPosition: true,
  //       accessibility: true,
  //       wrapAround: true,
  //       prevNextButtons: !Modernizr.touchevents,
  //       // prevNextButtons: false,
  //       pageDots: false,
  //       draggable: Modernizr.touchevents,
  //       dragThreshold: 30,
  //       selectedAttraction: 0.07,
  //       friction: 0.5
  //     });
  //     slider.slidesCount = slider.slides.length;
  //     if (slider.slidesCount < 1) return; // Stop if no slides
  //     let slideNumber = slider.element.parentNode.querySelector(".slide-number");
  //     let navPrev = slider.element.parentNode.querySelector(".nav-previous");
  //     let navNext = slider.element.parentNode.querySelector(".nav-next");
  //     let captionElement = slider.element.parentNode.querySelector(".caption");
  //     slider.on('select', function() {
  //       if (slideNumber)
  //         slideNumber.innerHTML = (slider.selectedIndex + 1) + '/' + slider.slidesCount;
  //       if (this.selectedElement) {
  //         let captionElement = this.element.parentNode.querySelector(".caption");
  //         if (captionElement)
  //           captionElement.innerHTML = this.selectedElement.getAttribute("data-caption");
  //       }
  //       var adjCellElems = this.getAdjacentCellElements(1);
  //       for (var i = 0; i < adjCellElems.length; i++) {
  //         var adjCellImgs = adjCellElems[i].querySelectorAll('.lazy:not(.lazyloaded):not(.lazyload)')
  //         for (var j = 0; j < adjCellImgs.length; j++) {
  //           adjCellImgs[j].classList.add('lazyload')
  //         }
  //       }
  //     });
  //     slider.on('staticClick', function(event, pointer, cellElement, cellIndex) {
  //       if (!cellElement || cellElement.getAttribute('data-media') == "video" && !slider.element.classList.contains('nav-hover')) {
  //         return;
  //       } else {
  //         this.next();
  //       }
  //     });
  //     if (slider.selectedElement && captionElement) {
  //       captionElement.innerHTML = slider.selectedElement.getAttribute("data-caption");
  //     }
  //     if (navPrev && navNext) {
  //       navPrev.addEventListener('click', () => {
  //         slider.previous();
  //       });
  //       navNext.addEventListener('click', () => {
  //         slider.next();
  //       });
  //     }
  //   };
  //   var flickitys = [];
  //   var elements = document.querySelectorAll('.slider');
  //   if (elements.length > 0) {
  //     for (var i = 0; i < elements.length; i++) {
  //       initFlickity(elements[i]);
  //     }
  //   }
  // },
  thumbnailSliders: () => {
    if (App.width < 1024) return;
    const initFlickity = (element) => {
      let slider = new Flickity(element, {
        cellSelector: 'img',
        autoPlay: 2000,
        pauseAutoPlayOnHover: false,
        // lazyLoad: true,
        setGallerySize: false,
        accessibility: false,
        wrapAround: true,
        prevNextButtons: false,
        pageDots: false,
        draggable: false,
      });
    };
    var flickitys = [];
    var elements = document.querySelectorAll('.thumbnail-slider');
    if (elements.length > 0) {
      for (var i = 0; i < elements.length; i++) {
        initFlickity(elements[i]);
      }
    }
  },
  pjax: () => {
    const transitionDuration = 300;
    const HideShowTransition = Barba.BaseTransition.extend({
      start: function() {
        let _this = this;
        App.body.classList.add("is-loading");
        setTimeout(function() {
          _this.newContainerLoading.then(_this.finish.bind(_this));
        }, transitionDuration);

      },
      finish: function() {
        window.scroll(0, 0);
        this.done();
        App.intro.destroy();
        App.body.classList.remove('menu-on', 'more-on', 'category-active');
        App.pageType = this.newContainer.querySelector('#page-content').getAttribute('page-type');
        App.body.setAttribute("page-type", App.pageType);
        setTimeout(function() {
          App.interact.init();
          App.body.classList.remove("is-loading");
        }, transitionDuration);
      }
    });
    Barba.Pjax.getTransition = function() {
      return HideShowTransition;
    };
    Barba.Pjax.Dom.wrapperId = "main";
    Barba.Pjax.Dom.containerClass = "pjax";
    Barba.Pjax.start();
  }
}
document.addEventListener("DOMContentLoaded", App.initialize);