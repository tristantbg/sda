/* jshint esversion: 6 */

import lazysizes from 'lazysizes';
import Flickity from 'flickity';
import throttle from 'lodash.throttle';
import Barba from 'barba.js';
import TweenMax from 'gsap';

const App = {
  body: null,
  width: null,
  height: null,
  container: null,
  header: null,
  menuBurger: null,
  categories: null,
  isMobile: null,
  initialize: () => {
    App.body = document.body;
    App.header = document.querySelector("header");
    App.categories = document.getElementById("main-categories");
    App.container = document.getElementById("main");
    App.sizeSet();
    App.pjax();
    App.interact.init();
    require('viewport-units-buggyfill').init();
    window.addEventListener('resize', throttle(App.sizeSet, 256), false);
    setTimeout(function() {
      document.getElementById("loader").style.display = "none";
    }, 0);
  },
  sizeSet: () => {
    App.width = window.innerWidth;
    App.height = window.innerHeight;
    if (App.width <= 770)
      App.isMobile = true;
    if (App.isMobile) {
      if (App.width >= 770) {
        //location.reload();
        App.isMobile = false;
      }
    }
  },
  interact: {
    init: () => {
      App.linkTargets();
      App.thumbnailSliders();
      App.interact.imagesScroll();
      App.interact.eventTargets();
    // App.interact.searchBar();
    },
    eventTargets: () => {
      App.interact.menuBurger();
      App.interact.filters();
    },
    imagesScroll: () => {
      const head = App.header.offsetHeight;
      const cover = document.getElementById('post-cover');
      let coverHidden = false;
      const postVisuals = document.getElementById('post-visuals');
      const figcaptions = document.querySelectorAll('figcaption[data-scroll]');
      const figures = document.querySelectorAll('figure[data-scroll]');

      const checkTagPosition = (event, first = false) => {
        if (cover && !coverHidden && !first) {
          cover.style.display = 'none';
          coverHidden = true;
        }
        const currentScroll = window.scrollY;
        let noTagFound = true;
        figures.forEach(function(el, index) {
          const touchTop = head - el.getBoundingClientRect().top;
          const touchBottom = head - el.getBoundingClientRect().bottom;
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
      };
      if (postVisuals) {
        if (cover) {
          cover.addEventListener('click', (e) => {
            cover.style.display = "none";
            coverHidden = true;
          });
        }
        figures.forEach(function(el, index) {
          const id = el.getAttribute("data-scroll");
          const img = el.querySelector("img");
          img.style.zIndex = 500 - index;
          img.setAttribute('data-scroll', id);
          postVisuals.appendChild(img);
        });
        window.addEventListener('scroll', throttle(checkTagPosition, 128), false);
        checkTagPosition(null, true);

      }
    },
    intro: () => {
      const intro = document.getElementById('intro');
      if (intro && App.body.classList.contains("with-intro")) {
        TweenMax.fromTo(App.header, 1.6, {
          autoAlpha: 1,
          yPercent: -130
        }, {
          autoAlpha: 1,
          yPercent: 0,
          ease: Power3.easeInOut
        });
        intro.addEventListener('click', () => {
          // intro.style.display = 'none';
          TweenMax.to(intro, 0.7, {
            autoAlpha: 0,
            scale: 1.2,
            ease: Power3.easeInOut,
            onComplete: () => {
              App.body.classList.remove("with-intro");
            }
          });
        });
      }
      App.interact.introSlider.init(intro);
    },
    filters: () => {

      const resultsBar = document.getElementById('results-bar');
      if (resultsBar) {
        const toggleFilters = document.getElementById('toggle-filters');
        toggleFilters.addEventListener('click', () => {
          resultsBar.classList.toggle('show-filters');
        })
      }

    },
    menuBurger: () => {
      App.menuBurger = document.getElementById("menu-burger");
      if (App.menuBurger) {
        App.menuBurger.addEventListener('click', () => {
          App.body.classList.toggle('menu-on');
        });
        const moreButtons = document.querySelectorAll('[event-target=additional-menu]');
        moreButtons.forEach((el) => {
          el.addEventListener('click', () => {
            App.body.classList.toggle('more-on');
          });
        });
      }
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
  loadSliders: () => {
    const initFlickity = (element) => {
      let slider = new Flickity(element, {
        cellSelector: '.slide',
        imagesLoaded: true,
        lazyLoad: 1,
        setGallerySize: true,
        adaptiveHeight: true,
        percentPosition: true,
        accessibility: true,
        wrapAround: true,
        prevNextButtons: !Modernizr.touchevents,
        // prevNextButtons: false,
        pageDots: false,
        draggable: Modernizr.touchevents,
        dragThreshold: 30,
        selectedAttraction: 0.07,
        friction: 0.5
      });
      slider.slidesCount = slider.slides.length;
      if (slider.slidesCount < 1) return; // Stop if no slides
      let slideNumber = slider.element.parentNode.querySelector(".slide-number");
      let navPrev = slider.element.parentNode.querySelector(".nav-previous");
      let navNext = slider.element.parentNode.querySelector(".nav-next");
      let captionElement = slider.element.parentNode.querySelector(".caption");
      slider.on('select', function() {
        if (slideNumber)
          slideNumber.innerHTML = (slider.selectedIndex + 1) + '/' + slider.slidesCount;
        if (this.selectedElement) {
          let captionElement = this.element.parentNode.querySelector(".caption");
          if (captionElement)
            captionElement.innerHTML = this.selectedElement.getAttribute("data-caption");
        }
        var adjCellElems = this.getAdjacentCellElements(1);
        for (var i = 0; i < adjCellElems.length; i++) {
          var adjCellImgs = adjCellElems[i].querySelectorAll('.lazy:not(.lazyloaded):not(.lazyload)')
          for (var j = 0; j < adjCellImgs.length; j++) {
            adjCellImgs[j].classList.add('lazyload')
          }
        }
      });
      slider.on('staticClick', function(event, pointer, cellElement, cellIndex) {
        if (!cellElement || cellElement.getAttribute('data-media') == "video" && !slider.element.classList.contains('nav-hover')) {
          return;
        } else {
          this.next();
        }
      });
      if (slider.selectedElement && captionElement) {
        captionElement.innerHTML = slider.selectedElement.getAttribute("data-caption");
      }
      if (navPrev && navNext) {
        navPrev.addEventListener('click', () => {
          slider.previous();
        });
        navNext.addEventListener('click', () => {
          slider.next();
        });
      }
    };
    var flickitys = [];
    var elements = document.querySelectorAll('.slider');
    if (elements.length > 0) {
      for (var i = 0; i < elements.length; i++) {
        initFlickity(elements[i]);
      }
    }
  },
  thumbnailSliders: () => {
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
    let transitionDuration = 300;
    let HideShowTransition = Barba.BaseTransition.extend({
      start: function() {
        App.body.classList.add("is-loading");
        this.newContainerLoading.then(this.finish.bind(this));
      },
      finish: function() {
        window.scroll(0, 0);
        this.done();
        App.body.classList.remove('menu-on', 'more-on');
        let pageType = this.newContainer.querySelector('#page-content').getAttribute('page-type');
        App.body.setAttribute("page-type", pageType)
        App.interact.init();
        App.body.classList.remove("is-loading");
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