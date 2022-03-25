/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "../node_modules/@fancyapps/ui/src/Carousel/Carousel.js":
/*!**************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Carousel/Carousel.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Carousel": function() { return /* binding */ Carousel; }
/* harmony export */ });
/* harmony import */ var _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../shared/Base/Base.js */ "../node_modules/@fancyapps/ui/src/shared/Base/Base.js");
/* harmony import */ var _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../Panzoom/Panzoom.js */ "../node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js");
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../shared/utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_round_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../shared/utils/round.js */ "../node_modules/@fancyapps/ui/src/shared/utils/round.js");
/* harmony import */ var _shared_utils_throttle_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../shared/utils/throttle.js */ "../node_modules/@fancyapps/ui/src/shared/utils/throttle.js");
/* harmony import */ var _plugins_index_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./plugins/index.js */ "../node_modules/@fancyapps/ui/src/Carousel/plugins/index.js");
/* harmony import */ var _l10n_en_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./l10n/en.js */ "../node_modules/@fancyapps/ui/src/Carousel/l10n/en.js");









// Default language


const defaults = {
  // Virtual slides. Each object should have at least `html` property that will be used to set content,
  // example: `slides: [{html: 'First slide'}, {html: 'Second slide'}]`
  slides: [],

  // Number of slides to preload before/after visible slides
  preload: 0,

  // Number of slides to group into the page,
  // if `auto` - group all slides that fit into the viewport
  slidesPerPage: "auto",

  // Index of initial page
  initialPage: null,

  // Index of initial slide
  initialSlide: null,

  // Panzoom friction while changing page
  friction: 0.92,

  // Should center active page
  center: true,

  // Should carousel scroll infinitely
  infinite: true,

  // Should the gap be filled before first and after last slide if `infinite: false`
  fill: true,

  // Should Carousel settle at any position after a swipe.
  dragFree: false,

  // Prefix for CSS classes, must be the same as the  SCSS `$carousel-prefix` variable
  prefix: "",

  // Class names for DOM elements (without prefix)
  classNames: {
    viewport: "carousel__viewport",
    track: "carousel__track",
    slide: "carousel__slide",

    // Classname toggled for slides inside current page
    slideSelected: "is-selected",
  },

  // Localization of strings
  l10n: _l10n_en_js__WEBPACK_IMPORTED_MODULE_6__["default"],
};

class Carousel extends _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_0__.Base {
  /**
   * Carousel constructor
   * @constructs Carousel
   * @param {HTMLElement} $container - Carousel container
   * @param {Object} [options] - Options for Carousel
   */
  constructor($container, options = {}) {
    options = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__.extend)(true, {}, defaults, options);

    super(options);

    this.state = "init";

    this.$container = $container;

    if (!(this.$container instanceof HTMLElement)) {
      throw new Error("No root element provided");
    }

    this.slideNext = (0,_shared_utils_throttle_js__WEBPACK_IMPORTED_MODULE_4__.throttle)(this.slideNext.bind(this), 250, true);
    this.slidePrev = (0,_shared_utils_throttle_js__WEBPACK_IMPORTED_MODULE_4__.throttle)(this.slidePrev.bind(this), 250, true);

    this.init();

    $container.__Carousel = this;
  }

  /**
   * Perform initialization
   */
  init() {
    this.pages = [];
    this.page = this.pageIndex = null;
    this.prevPage = this.prevPageIndex = null;

    this.attachPlugins(Carousel.Plugins);

    this.trigger("init");

    this.initLayout();

    this.initSlides();

    this.updateMetrics();

    if (this.$track && this.pages.length) {
      this.$track.style.transform = `translate3d(${this.pages[this.page].left * -1}px, 0px, 0) scale(1)`;
    }

    this.manageSlideVisiblity();

    this.initPanzoom();

    this.state = "ready";

    this.trigger("ready");
  }

  /**
   * Initialize layout; create necessary elements
   */
  initLayout() {
    const prefix = this.option("prefix");
    const classNames = this.option("classNames");

    this.$viewport = this.option("viewport") || this.$container.querySelector(`.${prefix}${classNames.viewport}`);

    if (!this.$viewport) {
      this.$viewport = document.createElement("div");
      this.$viewport.classList.add(...(prefix + classNames.viewport).split(" "));

      this.$viewport.append(...this.$container.childNodes);

      this.$container.appendChild(this.$viewport);
    }

    this.$track = this.option("track") || this.$container.querySelector(`.${prefix}${classNames.track}`);

    if (!this.$track) {
      this.$track = document.createElement("div");
      this.$track.classList.add(...(prefix + classNames.track).split(" "));

      this.$track.append(...this.$viewport.childNodes);

      this.$viewport.appendChild(this.$track);
    }
  }

  /**
   * Fill `slides` array with objects from existing nodes and/or `slides` option
   */
  initSlides() {
    this.slides = [];

    // Get existing slides from the DOM
    const elems = this.$viewport.querySelectorAll(`.${this.option("prefix")}${this.option("classNames.slide")}`);

    elems.forEach((el) => {
      const slide = {
        $el: el,
        isDom: true,
      };

      this.slides.push(slide);

      this.trigger("createSlide", slide, this.slides.length);
    });

    // Add virtual slides, but do not create DOM elements yet,
    // because they will be created dynamically based on current carousel position
    if (Array.isArray(this.options.slides)) {
      this.slides = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__.extend)(true, [...this.slides], this.options.slides);
    }
  }

  /**
   * Do all calculations related to slide size and paging
   */
  updateMetrics() {
    // Calculate content width, viewport width
    // ===
    let contentWidth = 0;
    let indexes = [];
    let lastSlideWidth;

    this.slides.forEach((slide, index) => {
      const $el = slide.$el;
      const slideWidth = slide.isDom || !lastSlideWidth ? this.getSlideMetrics($el) : lastSlideWidth;

      slide.index = index;
      slide.width = slideWidth;
      slide.left = contentWidth;

      lastSlideWidth = slideWidth;
      contentWidth += slideWidth;

      indexes.push(index);
    });

    let viewportWidth = Math.max(this.$track.offsetWidth, (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_3__.round)(this.$track.getBoundingClientRect().width));

    let viewportStyles = getComputedStyle(this.$track);
    viewportWidth = viewportWidth - (parseFloat(viewportStyles.paddingLeft) + parseFloat(viewportStyles.paddingRight));

    this.contentWidth = contentWidth;
    this.viewportWidth = viewportWidth;

    // Split slides into pages
    // ===
    const pages = [];
    const slidesPerPage = this.option("slidesPerPage");

    if (Number.isInteger(slidesPerPage) && contentWidth > viewportWidth) {
      // Fixed number of slides in the page
      for (let i = 0; i < this.slides.length; i += slidesPerPage) {
        pages.push({
          indexes: indexes.slice(i, i + slidesPerPage),
          slides: this.slides.slice(i, i + slidesPerPage),
        });
      }
    } else {
      // Slides that fit inside viewport
      let currentPage = 0;
      let currentWidth = 0;

      for (let i = 0; i < this.slides.length; i += 1) {
        let slide = this.slides[i];

        // Add next page
        if (!pages.length || currentWidth + slide.width > viewportWidth) {
          pages.push({
            indexes: [],
            slides: [],
          });

          currentPage = pages.length - 1;
          currentWidth = 0;
        }

        currentWidth += slide.width;

        pages[currentPage].indexes.push(i);
        pages[currentPage].slides.push(slide);
      }
    }

    const shouldCenter = this.option("center");
    const shouldFill = this.option("fill");

    // Calculate width and start position for each page
    // ===
    pages.forEach((page, index) => {
      page.index = index;
      page.width = page.slides.reduce((sum, slide) => sum + slide.width, 0);

      page.left = page.slides[0].left;

      if (shouldCenter) {
        page.left += (viewportWidth - page.width) * 0.5 * -1;
      }

      if (shouldFill && !this.option("infiniteX", this.option("infinite")) && contentWidth > viewportWidth) {
        page.left = Math.max(page.left, 0);
        page.left = Math.min(page.left, contentWidth - viewportWidth);
      }
    });

    // Merge pages
    // ===
    const rez = [];
    let prevPage;

    pages.forEach((page2) => {
      const page = { ...page2 };

      if (prevPage && page.left === prevPage.left) {
        prevPage.width += page.width;

        prevPage.slides = [...prevPage.slides, ...page.slides];
        prevPage.indexes = [...prevPage.indexes, ...page.indexes];
      } else {
        page.index = rez.length;

        prevPage = page;

        rez.push(page);
      }
    });

    this.pages = rez;

    let page = this.page;

    if (page === null) {
      const initialSlide = this.option("initialSlide");

      if (initialSlide !== null) {
        page = this.findPageForSlide(initialSlide);
      } else {
        page = parseInt(this.option("initialPage", 0), 10) || 0;
      }

      if (!rez[page]) {
        page = rez.length && page > rez.length ? rez[rez.length - 1].index : 0;
      }

      this.page = page;
      this.pageIndex = page;
    }

    this.updatePanzoom();

    this.trigger("refresh");
  }

  /**
   * Calculate slide element width (including left, right margins)
   * @param {Object} node
   * @returns {Number} Width in px
   */
  getSlideMetrics(node) {
    if (!node) {
      const firstSlide = this.slides[0];

      node = document.createElement("div");

      node.dataset.isTestEl = 1;
      node.style.visibility = "hidden";
      node.classList.add(...(this.option("prefix") + this.option("classNames.slide")).split(" "));

      // Assume all slides have the same custom class, if any
      if (firstSlide.customClass) {
        node.classList.add(...firstSlide.customClass.split(" "));
      }

      this.$track.prepend(node);
    }

    let width = Math.max(node.offsetWidth, (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_3__.round)(node.getBoundingClientRect().width));

    // Add left/right margin
    const style = node.currentStyle || window.getComputedStyle(node);
    width = width + (parseFloat(style.marginLeft) || 0) + (parseFloat(style.marginRight) || 0);

    if (node.dataset.isTestEl) {
      node.remove();
    }

    return width;
  }

  /**
   *
   * @param {Integer} index Index of the slide
   * @returns {Integer|null} Index of the page if found, or null
   */
  findPageForSlide(index) {
    index = parseInt(index, 10) || 0;

    const page = this.pages.find((page) => {
      return page.indexes.indexOf(index) > -1;
    });

    return page ? page.index : null;
  }

  /**
   * Slide to next page, if possible
   */
  slideNext() {
    this.slideTo(this.pageIndex + 1);
  }

  /**
   * Slide to previous page, if possible
   */
  slidePrev() {
    this.slideTo(this.pageIndex - 1);
  }

  /**
   * Slides carousel to given page
   * @param {Number} page - New index of active page
   * @param {Object} [params] - Additional options
   */
  slideTo(page, params = {}) {
    const { x = this.setPage(page, true) * -1, y = 0, friction = this.option("friction") } = params;

    if (this.Panzoom.content.x === x && !this.Panzoom.velocity.x && friction) {
      return;
    }

    this.Panzoom.panTo({
      x,
      y,
      friction,
      ignoreBounds: true,
    });

    if (this.state === "ready" && this.Panzoom.state === "ready") {
      this.trigger("settle");
    }
  }

  /**
   * Initialise main Panzoom instance
   */
  initPanzoom() {
    if (this.Panzoom) {
      this.Panzoom.destroy();
    }

    // Create fresh object containing options for Pazoom instance
    const options = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__.extend)(
      true,
      {},
      {
        // Track element will be set as Panzoom $content
        content: this.$track,
        wrapInner: false,
        resizeParent: false,

        // Disable any user interaction
        zoom: false,
        click: false,

        // Right now, only horizontal navigation is supported
        lockAxis: "x",

        x: this.pages.length ? this.pages[this.page].left * -1 : 0,
        centerOnStart: false,

        // Make `textSelection` option more easy to customize
        textSelection: () => this.option("textSelection", false),

        // Disable dragging if content (e.g. all slides) fits inside viewport
        panOnlyZoomed: function () {
          return this.content.width <= this.viewport.width;
        },
      },
      this.option("Panzoom")
    );

    // Create new Panzoom instance
    this.Panzoom = new _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__.Panzoom(this.$container, options);

    this.Panzoom.on({
      // Bubble events
      "*": (name, ...details) => this.trigger(`Panzoom.${name}`, ...details),
      // The rest of events to be processed
      afterUpdate: () => {
        this.updatePage();
      },
      beforeTransform: this.onBeforeTransform.bind(this),
      touchEnd: this.onTouchEnd.bind(this),
      endAnimation: () => {
        this.trigger("settle");
      },
    });

    // The contents of the slides may cause the page scroll bar to appear, so the carousel width may change
    // and slides have to be repositioned
    this.updateMetrics();
    this.manageSlideVisiblity();
  }

  updatePanzoom() {
    if (!this.Panzoom) {
      return;
    }

    this.Panzoom.content = {
      ...this.Panzoom.content,
      fitWidth: this.contentWidth,
      origWidth: this.contentWidth,
      width: this.contentWidth,
    };

    if (this.pages.length > 1 && this.option("infiniteX", this.option("infinite"))) {
      this.Panzoom.boundX = null;
    } else if (this.pages.length) {
      this.Panzoom.boundX = {
        from: this.pages[this.pages.length - 1].left * -1,
        to: this.pages[0].left * -1,
      };
    }

    if (this.option("infiniteY", this.option("infinite"))) {
      this.Panzoom.boundY = null;
    } else {
      this.Panzoom.boundY = {
        from: 0,
        to: 0,
      };
    }

    this.Panzoom.handleCursor();
  }

  manageSlideVisiblity() {
    const contentWidth = this.contentWidth;
    const viewportWidth = this.viewportWidth;

    let currentX = this.Panzoom ? this.Panzoom.content.x * -1 : this.pages.length ? this.pages[this.page].left : 0;

    const preload = this.option("preload");
    const infinite = this.option("infiniteX", this.option("infinite"));

    const paddingLeft = parseFloat(getComputedStyle(this.$viewport, null).getPropertyValue("padding-left"));
    const paddingRight = parseFloat(getComputedStyle(this.$viewport, null).getPropertyValue("padding-right"));

    // Check visibility of each slide
    this.slides.forEach((slide) => {
      let leftBoundary, rightBoundary;

      let hasDiff = 0;

      // #1 - slides in current viewport; this does not include infinite items
      leftBoundary = currentX - paddingLeft;
      rightBoundary = currentX + viewportWidth + paddingRight;

      leftBoundary -= preload * (viewportWidth + paddingLeft + paddingRight);
      rightBoundary += preload * (viewportWidth + paddingLeft + paddingRight);

      const insideCurrentInterval = slide.left + slide.width > leftBoundary && slide.left < rightBoundary;

      // #2 - infinite items inside current viewport; from previous interval
      leftBoundary = currentX + contentWidth - paddingLeft;
      rightBoundary = currentX + contentWidth + viewportWidth + paddingRight;

      // Include slides that have to be preloaded
      leftBoundary -= preload * (viewportWidth + paddingLeft + paddingRight);

      const insidePrevInterval = infinite && slide.left + slide.width > leftBoundary && slide.left < rightBoundary;

      // #2 - infinite items inside current viewport; from next interval
      leftBoundary = currentX - contentWidth - paddingLeft;
      rightBoundary = currentX - contentWidth + viewportWidth + paddingRight;

      // Include slides that have to be preloaded
      leftBoundary -= preload * (viewportWidth + paddingLeft + paddingRight);

      const insideNextInterval = infinite && slide.left + slide.width > leftBoundary && slide.left < rightBoundary;

      // Create virtual slides that should be visible or preloaded, remove others
      if (insidePrevInterval || insideCurrentInterval || insideNextInterval) {
        this.createSlideEl(slide);

        if (insideCurrentInterval) {
          hasDiff = 0;
        }

        if (insidePrevInterval) {
          hasDiff = -1;
        }

        if (insideNextInterval) {
          hasDiff = 1;
        }

        // Bring preloaded slides back to viewport, if needed
        if (slide.left + slide.width > currentX && slide.left <= currentX + viewportWidth + paddingRight) {
          hasDiff = 0;
        }
      } else {
        this.removeSlideEl(slide);
      }

      slide.hasDiff = hasDiff;
    });

    // Reposition slides for continuity
    let nextIndex = 0;
    let nextPos = 0;

    this.slides.forEach((slide, index) => {
      let updatedX = 0;

      if (slide.$el) {
        if (index !== nextIndex || slide.hasDiff) {
          updatedX = nextPos + slide.hasDiff * contentWidth;
        } else {
          nextPos = 0;
        }

        slide.$el.style.left = Math.abs(updatedX) > 0.1 ? `${nextPos + slide.hasDiff * contentWidth}px` : "";

        nextIndex++;
      } else {
        nextPos += slide.width;
      }
    });

    this.markSelectedSlides();
  }

  /**
   * Creates main DOM element for virtual slides,
   * lazy loads images inside regular slides
   * @param {Object} slide
   */
  createSlideEl(slide) {
    if (!slide) {
      return;
    }

    if (slide.$el) {
      let curentIndex = slide.$el.dataset.index;

      if (!curentIndex || parseInt(curentIndex, 10) !== slide.index) {
        slide.$el.dataset.index = slide.index;

        // Lazy load images
        // ===
        slide.$el.querySelectorAll("[data-lazy-srcset]").forEach((node) => {
          node.srcset = node.dataset.lazySrcset;
        });

        slide.$el.querySelectorAll("[data-lazy-src]").forEach((node) => {
          let lazySrc = node.dataset.lazySrc;

          if (node instanceof HTMLImageElement) {
            node.src = lazySrc;
          } else {
            node.style.backgroundImage = `url('${lazySrc}')`;
          }
        });

        // Lazy load slide background image
        // ===
        let lazySrc;

        if ((lazySrc = slide.$el.dataset.lazySrc)) {
          slide.$el.style.backgroundImage = `url('${lazySrc}')`;
        }

        slide.state = "ready";
      }

      return;
    }

    const div = document.createElement("div");

    div.dataset.index = slide.index;
    div.classList.add(...(this.option("prefix") + this.option("classNames.slide")).split(" "));

    if (slide.customClass) {
      div.classList.add(...slide.customClass.split(" "));
    }

    if (slide.html) {
      div.innerHTML = slide.html;
    }

    const allElelements = [];

    this.slides.forEach((slide, index) => {
      if (slide.$el) {
        allElelements.push(index);
      }
    });

    // Find a place in DOM to insert an element
    const goal = slide.index;
    let refSlide = null;

    if (allElelements.length) {
      let refIndex = allElelements.reduce((prev, curr) =>
        Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev
      );
      refSlide = this.slides[refIndex];
    }

    this.$track.insertBefore(
      div,
      refSlide && refSlide.$el ? (refSlide.index < slide.index ? refSlide.$el.nextSibling : refSlide.$el) : null
    );

    slide.$el = div;

    this.trigger("createSlide", slide, goal);

    return slide;
  }

  /**
   * Removes main DOM element of given slide
   * @param {Object} slide
   */
  removeSlideEl(slide) {
    if (slide.$el && !slide.isDom) {
      this.trigger("removeSlide", slide);

      slide.$el.remove();
      slide.$el = null;
    }
  }

  /**
   * Toggles selected class name and aria-hidden attribute for slides based on visibility
   */
  markSelectedSlides() {
    const selectedClass = this.option("classNames.slideSelected");
    const attr = "aria-hidden";

    this.slides.forEach((slide, index) => {
      const $el = slide.$el;

      if (!$el) {
        return;
      }

      const page = this.pages[this.page];

      if (page && page.indexes && page.indexes.indexOf(index) > -1) {
        if (selectedClass && !$el.classList.contains(selectedClass)) {
          $el.classList.add(selectedClass);
          this.trigger("selectSlide", slide);
        }

        $el.removeAttribute(attr);
      } else {
        if (selectedClass && $el.classList.contains(selectedClass)) {
          $el.classList.remove(selectedClass);
          this.trigger("unselectSlide", slide);
        }

        $el.setAttribute(attr, true);
      }
    });
  }

  /**
   * Perform all calculations and center current page
   */
  updatePage() {
    this.updateMetrics();

    this.slideTo(this.page, { friction: 0 });
  }

  /**
   * Process `Panzoom.beforeTransform` event to remove slides moved out of viewport and
   * to create necessary ones
   */
  onBeforeTransform() {
    if (this.option("infiniteX", this.option("infinite"))) {
      this.manageInfiniteTrack();
    }

    this.manageSlideVisiblity();
  }

  /**
   * Seamlessly flip position of infinite carousel, if needed; this way x position stays low
   */
  manageInfiniteTrack() {
    const contentWidth = this.contentWidth;
    const viewportWidth = this.viewportWidth;

    if (!this.option("infiniteX", this.option("infinite")) || this.pages.length < 2 || contentWidth < viewportWidth) {
      return;
    }

    const panzoom = this.Panzoom;

    let isFlipped = false;

    if (panzoom.content.x < (contentWidth - viewportWidth) * -1) {
      panzoom.content.x += contentWidth;

      this.pageIndex = this.pageIndex - this.pages.length;

      isFlipped = true;
    }

    if (panzoom.content.x > viewportWidth) {
      panzoom.content.x -= contentWidth;

      this.pageIndex = this.pageIndex + this.pages.length;

      isFlipped = true;
    }

    if (isFlipped && panzoom.state === "pointerdown") {
      panzoom.resetDragPosition();
    }

    return isFlipped;
  }

  /**
   * Process `Panzoom.touchEnd` event; slide to next/prev page if needed
   * @param {object} panzoom
   */
  onTouchEnd(panzoom, event) {
    const dragFree = this.option("dragFree");

    // If this is a quick horizontal flick, slide to next/prev slide
    if (
      !dragFree &&
      this.pages.length > 1 &&
      panzoom.dragOffset.time < 350 &&
      Math.abs(panzoom.dragOffset.y) < 1 &&
      Math.abs(panzoom.dragOffset.x) > 5
    ) {
      this[panzoom.dragOffset.x < 0 ? "slideNext" : "slidePrev"]();
      return;
    }

    // Set the slide at the end of the animation as the current one,
    // or slide to closest page
    if (dragFree) {
      const [, nextPageIndex] = this.getPageFromPosition(panzoom.transform.x * -1);
      this.setPage(nextPageIndex);
    } else {
      this.slideToClosest();
    }
  }

  /**
   * Slides to the closest page (useful, if carousel is changed manually)
   * @param {Object} [params] - Object containing additional options
   */
  slideToClosest(params = {}) {
    let [, nextPageIndex] = this.getPageFromPosition(this.Panzoom.content.x * -1);

    this.slideTo(nextPageIndex, params);
  }

  /**
   * Returns index of closest page to given x position
   * @param {Number} xPos
   */
  getPageFromPosition(xPos) {
    const pageCount = this.pages.length;
    const center = this.option("center");

    if (center) {
      xPos += this.viewportWidth * 0.5;
    }

    const interval = Math.floor(xPos / this.contentWidth);

    xPos -= interval * this.contentWidth;

    let slide = this.slides.find((slide) => slide.left <= xPos && slide.left + slide.width > xPos);

    if (slide) {
      let pageIndex = this.findPageForSlide(slide.index);

      return [pageIndex, pageIndex + interval * pageCount];
    }

    return [0, 0];
  }

  /**
   * Changes active page
   * @param {Number} page - New index of active page
   * @param {Boolean} toClosest - to closest page based on scroll distance (for infinite navigation)
   */
  setPage(page, toClosest) {
    let nextPosition = 0;
    let pageIndex = parseInt(page, 10) || 0;

    const prevPage = this.page,
      prevPageIndex = this.pageIndex,
      pageCount = this.pages.length;

    const contentWidth = this.contentWidth;
    const viewportWidth = this.viewportWidth;

    page = ((pageIndex % pageCount) + pageCount) % pageCount;

    if (this.option("infiniteX", this.option("infinite")) && contentWidth > viewportWidth) {
      const nextInterval = Math.floor(pageIndex / pageCount) || 0,
        elemDimWidth = contentWidth;

      nextPosition = this.pages[page].left + nextInterval * elemDimWidth;

      if (toClosest === true && pageCount > 2) {
        let currPosition = this.Panzoom.content.x * -1;

        // * Find closest interval
        const decreasedPosition = nextPosition - elemDimWidth,
          increasedPosition = nextPosition + elemDimWidth,
          diff1 = Math.abs(currPosition - nextPosition),
          diff2 = Math.abs(currPosition - decreasedPosition),
          diff3 = Math.abs(currPosition - increasedPosition);

        if (diff3 < diff1 && diff3 <= diff2) {
          nextPosition = increasedPosition;
          pageIndex += pageCount;
        } else if (diff2 < diff1 && diff2 < diff3) {
          nextPosition = decreasedPosition;
          pageIndex -= pageCount;
        }
      }
    } else {
      page = pageIndex = Math.max(0, Math.min(pageIndex, pageCount - 1));

      nextPosition = this.pages.length ? this.pages[page].left : 0;
    }

    this.page = page;
    this.pageIndex = pageIndex;

    if (prevPage !== null && page !== prevPage) {
      this.prevPage = prevPage;
      this.prevPageIndex = prevPageIndex;

      this.trigger("change", page, prevPage);
    }

    return nextPosition;
  }

  /**
   * Clean up
   */
  destroy() {
    this.state = "destroy";

    this.slides.forEach((slide) => {
      this.removeSlideEl(slide);
    });

    this.slides = [];

    this.Panzoom.destroy();

    this.detachPlugins();
  }
}

// Expose version
Carousel.version = "__VERSION__";

// Static properties are a recent addition that dont work in all browsers yet
Carousel.Plugins = _plugins_index_js__WEBPACK_IMPORTED_MODULE_5__.Plugins;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Carousel/l10n/en.js":
/*!*************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Carousel/l10n/en.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__) {

/* harmony default export */ __webpack_exports__["default"] = ({
  NEXT: "Next slide",
  PREV: "Previous slide",
  GOTO: "Go to slide #%d",
});


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Carousel/plugins/Dots/Dots.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Carousel/plugins/Dots/Dots.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Dots": function() { return /* binding */ Dots; }
/* harmony export */ });
const defaults = {
  // The minimum number of slides to display dots
  minSlideCount: 2,
};

class Dots {
  constructor(carousel) {
    this.carousel = carousel;

    this.$list = null;

    this.events = {
      change: this.onChange.bind(this),
      refresh: this.onRefresh.bind(this),
    };
  }

  /**
   * Build wrapping DOM element containing all dots
   */
  buildList() {
    if (this.carousel.pages.length < this.carousel.option("Dots.minSlideCount")) {
      return;
    }

    const $list = document.createElement("ol");

    $list.classList.add("carousel__dots");

    $list.addEventListener("click", (e) => {
      if (!("page" in e.target.dataset)) {
        return;
      }

      e.preventDefault();
      e.stopPropagation();

      const page = parseInt(e.target.dataset.page, 10);
      const carousel = this.carousel;

      if (page === carousel.page) {
        return;
      }

      if (carousel.pages.length < 3 && carousel.option("infinite")) {
        carousel[page == 0 ? "slidePrev" : "slideNext"]();
      } else {
        carousel.slideTo(page);
      }
    });

    this.$list = $list;

    this.carousel.$container.appendChild($list);
    this.carousel.$container.classList.add("has-dots");

    return $list;
  }

  /**
   * Remove wrapping DOM element
   */
  removeList() {
    if (this.$list) {
      this.$list.parentNode.removeChild(this.$list);
      this.$list = null;
    }

    this.carousel.$container.classList.remove("has-dots");
  }

  /**
   * Remove existing dots and create fresh ones
   */
  rebuildDots() {
    let $list = this.$list;

    const listExists = !!$list;
    const pagesCount = this.carousel.pages.length;

    if (pagesCount < 2) {
      if (listExists) {
        this.removeList();
      }

      return;
    }

    if (!listExists) {
      $list = this.buildList();
    }

    // Remove existing dots
    const dotCount = this.$list.children.length;

    if (dotCount > pagesCount) {
      for (let i = pagesCount; i < dotCount; i++) {
        this.$list.removeChild(this.$list.lastChild);
      }

      return;
    }

    // Create fresh DOM elements (dots) for each page
    for (let index = dotCount; index < pagesCount; index++) {
      const $dot = document.createElement("li");

      $dot.classList.add("carousel__dot");
      $dot.dataset.page = index;

      $dot.setAttribute("role", "button");
      $dot.setAttribute("tabindex", "0");
      $dot.setAttribute("title", this.carousel.localize("{{GOTO}}", [["%d", index + 1]]));

      $dot.addEventListener("keydown", (event) => {
        const code = event.code;

        let $el;

        if (code === "Enter" || code === "NumpadEnter") {
          $el = $dot;
        } else if (code === "ArrowRight") {
          $el = $dot.nextSibling;
        } else if (code === "ArrowLeft") {
          $el = $dot.previousSibling;
        }

        $el && $el.click();
      });

      this.$list.appendChild($dot);
    }

    this.setActiveDot();
  }

  /**
   * Mark active dot by toggling class name
   */
  setActiveDot() {
    if (!this.$list) {
      return;
    }

    this.$list.childNodes.forEach(($dot) => {
      $dot.classList.remove("is-selected");
    });

    const $activeDot = this.$list.childNodes[this.carousel.page];

    if ($activeDot) {
      $activeDot.classList.add("is-selected");
    }
  }

  /**
   * Process carousel `change` event
   */
  onChange() {
    this.setActiveDot();
  }

  /**
   * Process carousel `refresh` event
   */
  onRefresh() {
    this.rebuildDots();
  }

  attach() {
    this.carousel.on(this.events);
  }

  detach() {
    this.removeList();

    this.carousel.off(this.events);
    this.carousel = null;
  }
}


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Carousel/plugins/Navigation/Navigation.js":
/*!***********************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Carousel/plugins/Navigation/Navigation.js ***!
  \***********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Navigation": function() { return /* binding */ Navigation; }
/* harmony export */ });
const defaults = {
  prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 3l-9 9 9 9"/></svg>',
  nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M9 3l9 9-9 9"/></svg>',

  classNames: {
    main: "carousel__nav",
    button: "carousel__button",

    next: "is-next",
    prev: "is-prev",
  },
};

class Navigation {
  constructor(carousel) {
    this.$container = null;

    this.$prev = null;
    this.$next = null;

    this.carousel = carousel;

    this.onRefresh = this.onRefresh.bind(this);
  }

  /**
   * Shortcut to get option for this plugin
   * @param {String} name option name
   * @returns option value
   */
  option(name) {
    return this.carousel.option(`Navigation.${name}`);
  }

  /**
   * Creates and returns new button element with default class names and click event
   * @param {String} type
   */
  createButton(type) {
    const $btn = document.createElement("button");

    $btn.setAttribute("title", this.carousel.localize(`{{${type.toUpperCase()}}}`));

    const classNames = this.option("classNames.button") + " " + this.option(`classNames.${type}`);

    $btn.classList.add(...classNames.split(" "));
    $btn.setAttribute("tabindex", "0");
    $btn.innerHTML = this.carousel.localize(this.option(`${type}Tpl`));

    $btn.addEventListener("click", (event) => {
      event.preventDefault();
      event.stopPropagation();

      this.carousel[`slide${type === "next" ? "Next" : "Prev"}`]();
    });

    return $btn;
  }

  /**
   * Build necessary DOM elements
   */
  build() {
    if (!this.$container) {
      this.$container = document.createElement("div");
      this.$container.classList.add(...this.option("classNames.main").split(" "));

      this.carousel.$container.appendChild(this.$container);
    }

    if (!this.$next) {
      this.$next = this.createButton("next");

      this.$container.appendChild(this.$next);
    }

    if (!this.$prev) {
      this.$prev = this.createButton("prev");

      this.$container.appendChild(this.$prev);
    }
  }

  /**
   *  Process carousel `refresh` and `change` events to enable/disable buttons if needed
   */
  onRefresh() {
    const pageCount = this.carousel.pages.length;

    if (
      pageCount <= 1 ||
      (pageCount > 1 &&
        this.carousel.elemDimWidth < this.carousel.wrapDimWidth &&
        !Number.isInteger(this.carousel.option("slidesPerPage")))
    ) {
      this.cleanup();

      return;
    }

    this.build();

    this.$prev.removeAttribute("disabled");
    this.$next.removeAttribute("disabled");

    if (this.carousel.option("infiniteX", this.carousel.option("infinite"))) {
      return;
    }

    if (this.carousel.page <= 0) {
      this.$prev.setAttribute("disabled", "");
    }

    if (this.carousel.page >= pageCount - 1) {
      this.$next.setAttribute("disabled", "");
    }
  }

  cleanup() {
    if (this.$prev) {
      this.$prev.remove();
    }

    this.$prev = null;

    if (this.$next) {
      this.$next.remove();
    }

    this.$next = null;

    if (this.$container) {
      this.$container.remove();
    }

    this.$container = null;
  }

  attach() {
    this.carousel.on("refresh change", this.onRefresh);
  }

  detach() {
    this.carousel.off("refresh change", this.onRefresh);

    this.cleanup();
  }
}

// Expose defaults
Navigation.defaults = defaults;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Carousel/plugins/Sync/Sync.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Carousel/plugins/Sync/Sync.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Sync": function() { return /* binding */ Sync; }
/* harmony export */ });
const defaults = {
  friction: 0.92,
};

class Sync {
  constructor(carousel) {
    this.carousel = carousel;

    this.selectedIndex = null;
    this.friction = 0;

    this.onNavReady = this.onNavReady.bind(this);
    this.onNavClick = this.onNavClick.bind(this);
    this.onNavCreateSlide = this.onNavCreateSlide.bind(this);

    this.onTargetChange = this.onTargetChange.bind(this);
  }

  /**
   * Make this one as main carousel and selected carousel as navigation
   * @param {Object} nav Carousel
   */
  addAsTargetFor(nav) {
    this.target = this.carousel;
    this.nav = nav;

    this.attachEvents();
  }

  /**
   * Make this one as navigation carousel for selected carousel
   * @param {Object} target
   */
  addAsNavFor(target) {
    this.target = target;
    this.nav = this.carousel;

    this.attachEvents();
  }

  /**
   * Attach event listeners on both carousels
   */
  attachEvents() {
    this.nav.options.initialSlide = this.target.options.initialPage;

    this.nav.on("ready", this.onNavReady);
    this.nav.on("createSlide", this.onNavCreateSlide);
    this.nav.on("Panzoom.click", this.onNavClick);

    this.target.on("change", this.onTargetChange);
    this.target.on("Panzoom.afterUpdate", this.onTargetChange);
  }

  /**
   * Process main carousel `ready` event; bind events and set initial page
   */
  onNavReady() {
    this.onTargetChange(true);
  }

  /**
   * Process main carousel `click` event
   * @param {Object} panzoom
   * @param {Object} event
   */
  onNavClick(carousel, panzoom, event) {
    const clickedNavSlide = event.target.closest(".carousel__slide");

    if (!clickedNavSlide) {
      return;
    }

    event.stopPropagation();

    const selectedNavIndex = parseInt(clickedNavSlide.dataset.index, 10);
    const selectedSyncPage = this.target.findPageForSlide(selectedNavIndex);

    if (this.target.page !== selectedSyncPage) {
      this.target.slideTo(selectedSyncPage, { friction: this.friction });
    }

    this.markSelectedSlide(selectedNavIndex);
  }

  /**
   * Process main carousel `createSlide` event
   * @param {Object} carousel
   * @param {Object} slide
   */
  onNavCreateSlide(carousel, slide) {
    if (slide.index === this.selectedIndex) {
      this.markSelectedSlide(slide.index);
    }
  }

  /**
   * Process target carousel `change` event
   * @param {Object} target
   */
  onTargetChange() {
    const targetIndex = this.target.pages[this.target.page].indexes[0];
    const selectedNavPage = this.nav.findPageForSlide(targetIndex);

    this.nav.slideTo(selectedNavPage);

    this.markSelectedSlide(targetIndex);
  }

  /**
   * Toggle classname for slides that marks currently selected slides
   * @param {Number} selectedIndex
   */
  markSelectedSlide(selectedIndex) {
    this.selectedIndex = selectedIndex;

    [...this.nav.slides].filter((slide) => slide.$el && slide.$el.classList.remove("is-nav-selected"));

    const slide = this.nav.slides[selectedIndex];

    if (slide && slide.$el) slide.$el.classList.add("is-nav-selected");
  }

  attach(carousel) {
    const sync = carousel.options.Sync;

    if (!sync.target && !sync.nav) {
      return;
    }

    if (sync.target) {
      this.addAsNavFor(sync.target);
    } else if (sync.nav) {
      this.addAsTargetFor(sync.nav);
    }

    this.friction = sync.friction;
  }

  detach() {
    if (this.nav) {
      this.nav.off("ready", this.onNavReady);
      this.nav.off("Panzoom.click", this.onNavClick);
      this.nav.off("createSlide", this.onNavCreateSlide);
    }

    if (this.target) {
      this.target.off("Panzoom.afterUpdate", this.onTargetChange);
      this.target.off("change", this.onTargetChange);
    }
  }
}

// Expose defaults
Sync.defaults = defaults;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Carousel/plugins/index.js":
/*!*******************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Carousel/plugins/index.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Plugins": function() { return /* binding */ Plugins; }
/* harmony export */ });
/* harmony import */ var _Navigation_Navigation_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navigation/Navigation.js */ "../node_modules/@fancyapps/ui/src/Carousel/plugins/Navigation/Navigation.js");
/* harmony import */ var _Dots_Dots_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dots/Dots.js */ "../node_modules/@fancyapps/ui/src/Carousel/plugins/Dots/Dots.js");
/* harmony import */ var _Sync_Sync_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Sync/Sync.js */ "../node_modules/@fancyapps/ui/src/Carousel/plugins/Sync/Sync.js");




const Plugins = { Navigation: _Navigation_Navigation_js__WEBPACK_IMPORTED_MODULE_0__.Navigation, Dots: _Dots_Dots_js__WEBPACK_IMPORTED_MODULE_1__.Dots, Sync: _Sync_Sync_js__WEBPACK_IMPORTED_MODULE_2__.Sync };


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/Fancybox.js":
/*!**************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/Fancybox.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Fancybox": function() { return /* binding */ Fancybox; }
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../shared/utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../shared/utils/canUseDOM.js */ "../node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js");
/* harmony import */ var _shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../shared/utils/setFocusOn.js */ "../node_modules/@fancyapps/ui/src/shared/utils/setFocusOn.js");
/* harmony import */ var _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../shared/Base/Base.js */ "../node_modules/@fancyapps/ui/src/shared/Base/Base.js");
/* harmony import */ var _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Carousel/Carousel.js */ "../node_modules/@fancyapps/ui/src/Carousel/Carousel.js");
/* harmony import */ var _plugins_index_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./plugins/index.js */ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/index.js");
/* harmony import */ var _l10n_en_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./l10n/en.js */ "../node_modules/@fancyapps/ui/src/Fancybox/l10n/en.js");










// Default language


// Default settings
const defaults = {
  // Index of active slide on the start
  startIndex: 0,

  // Number of slides to preload before and after active slide
  preload: 1,

  // Should navigation be infinite
  infinite: true,

  // Class name to be applied to the content to reveal it
  showClass: "fancybox-zoomInUp", // "fancybox-fadeIn" | "fancybox-zoomInUp" | false

  // Class name to be applied to the content to hide it
  hideClass: "fancybox-fadeOut", // "fancybox-fadeOut" | "fancybox-zoomOutDown" | false

  // Should backdrop and UI elements fade in/out on start/close
  animated: true,

  // If browser scrollbar should be hidden
  hideScrollbar: true,

  // Element containing main structure
  parentEl: null,

  // Custom class name or multiple space-separated class names for the container
  mainClass: null,

  // Set focus on first focusable element after displaying content
  autoFocus: true,

  // Trap focus inside Fancybox
  trapFocus: true,

  // Set focus back to trigger element after closing Fancybox
  placeFocusBack: true,

  // Action to take when the user clicks on the backdrop
  click: "close", // "close" | "next" | null

  // Position of the close button - over the content or at top right corner of viewport
  closeButton: "inside", // "inside" | "outside"

  // Allow user to drag content up/down to close instance
  dragToClose: true,

  // Enable keyboard navigation
  keyboard: {
    Escape: "close",
    Delete: "close",
    Backspace: "close",
    PageUp: "next",
    PageDown: "prev",
    ArrowUp: "next",
    ArrowDown: "prev",
    ArrowRight: "next",
    ArrowLeft: "prev",
  },

  // HTML templates for various elements
  template: {
    // Close button icon
    closeButton:
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"/></svg>',
    // Loading indicator icon
    spinner:
      '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="25 25 50 50" tabindex="-1"><circle cx="50" cy="50" r="20"/></svg>',

    // Main container element
    main: null,
  },

  /* Note: If the `template.main` option is not provided, the structure is generated as follows by default:
  <div class="fancybox__container" role="dialog" aria-modal="true" aria-hidden="true" aria-label="{{MODAL}}" tabindex="-1">
    <div class="fancybox__backdrop"></div>
    <div class="fancybox__carousel"></div>
  </div>
  */

  // Localization of strings
  l10n: _l10n_en_js__WEBPACK_IMPORTED_MODULE_6__["default"],
};

// Object that contains all active instances of Fancybox
const instances = new Map();

// Number of Fancybox instances created, it is used to generate new instance "id"
let called = 0;

class Fancybox extends _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_3__.Base {
  /**
   * Fancybox constructor
   * @constructs Fancybox
   * @param {Object} [options] - Options for Fancybox
   */
  constructor(items, options = {}) {
    // Quick hack to fix variable naming collision
    items = items.map((item) => {
      if (item.width) item._width = item.width;
      if (item.height) item._height = item.height;

      return item;
    });

    super((0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, {}, defaults, options));

    this.bindHandlers();

    this.state = "init";

    this.setItems(items);

    this.attachPlugins(Fancybox.Plugins);

    // "init" event marks the start of initialization and is available to plugins
    this.trigger("init");

    if (this.option("hideScrollbar") === true) {
      this.hideScrollbar();
    }

    this.initLayout();

    this.initCarousel();

    this.attachEvents();

    instances.set(this.id, this);

    // "prepare" event will trigger the creation of additional layout elements, such as thumbnails and toolbar
    this.trigger("prepare");

    this.state = "ready";

    // "ready" event will trigger the content to load
    this.trigger("ready");

    // Reveal container
    this.$container.setAttribute("aria-hidden", "false");

    // Set focus on the first focusable element inside this instance
    if (this.option("trapFocus")) {
      this.focus();
    }
  }

  /**
   * Override `option` method to get value from the current slide
   * @param {String} name option name
   * @param  {...any} rest optional extra parameters
   * @returns {any}
   */
  option(name, ...rest) {
    const slide = this.getSlide();

    let value = slide ? slide[name] : undefined;

    if (value !== undefined) {
      if (typeof value === "function") {
        value = value.call(this, this, ...rest);
      }

      return value;
    }

    return super.option(name, ...rest);
  }

  /**
   * Bind event handlers for referencability
   */
  bindHandlers() {
    for (const methodName of [
      "onMousedown",
      "onKeydown",
      "onClick",

      "onFocus",

      "onCreateSlide",
      "onSettle",

      "onTouchMove",
      "onTouchEnd",

      "onTransform",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }
  }

  /**
   * Set up a functions that will be called whenever the specified event is delivered
   */
  attachEvents() {
    document.addEventListener("mousedown", this.onMousedown);
    document.addEventListener("keydown", this.onKeydown, true);

    // Trap keyboard focus inside of the modal
    if (this.option("trapFocus")) {
      document.addEventListener("focus", this.onFocus, true);
    }

    this.$container.addEventListener("click", this.onClick);
  }

  /**
   * Removes previously registered event listeners
   */
  detachEvents() {
    document.removeEventListener("mousedown", this.onMousedown);
    document.removeEventListener("keydown", this.onKeydown, true);

    document.removeEventListener("focus", this.onFocus, true);

    this.$container.removeEventListener("click", this.onClick);
  }

  /**
   * Initialize layout; create main container, backdrop nd layout for main carousel
   */
  initLayout() {
    this.$root = this.option("parentEl") || document.body;

    // Container
    let mainTemplate = this.option("template.main");

    if (mainTemplate) {
      this.$root.insertAdjacentHTML("beforeend", this.localize(mainTemplate));

      this.$container = this.$root.querySelector(".fancybox__container");
    }

    if (!this.$container) {
      this.$container = document.createElement("div");
      this.$root.appendChild(this.$container);
    }

    // Normally we would not need this, but Safari does not support `preventScroll:false` option for `focus` method
    // and that causes layout issues
    this.$container.onscroll = () => {
      this.$container.scrollLeft = 0;
      return false;
    };

    Object.entries({
      class: "fancybox__container",
      role: "dialog",
      tabIndex: "-1",
      "aria-modal": "true",
      "aria-hidden": "true",
      "aria-label": this.localize("{{MODAL}}"),
    }).forEach((args) => this.$container.setAttribute(...args));

    if (this.option("animated")) {
      this.$container.classList.add("is-animated");
    }

    // Backdrop
    this.$backdrop = this.$container.querySelector(".fancybox__backdrop");

    if (!this.$backdrop) {
      this.$backdrop = document.createElement("div");
      this.$backdrop.classList.add("fancybox__backdrop");

      this.$container.appendChild(this.$backdrop);
    }

    // Carousel
    this.$carousel = this.$container.querySelector(".fancybox__carousel");

    if (!this.$carousel) {
      this.$carousel = document.createElement("div");
      this.$carousel.classList.add("fancybox__carousel");

      this.$container.appendChild(this.$carousel);
    }

    // Make instance reference accessible
    this.$container.Fancybox = this;

    // Make sure the container has an ID
    this.id = this.$container.getAttribute("id");

    if (!this.id) {
      this.id = this.options.id || ++called;
      this.$container.setAttribute("id", "fancybox-" + this.id);
    }

    // Add custom class name to main element
    const mainClass = this.option("mainClass");

    if (mainClass) {
      this.$container.classList.add(...mainClass.split(" "));
    }

    // Add class name for <html> element
    document.documentElement.classList.add("with-fancybox");

    this.trigger("initLayout");

    return this;
  }

  /**
   * Prepares slides for the corousel
   * @returns {Array} Slides
   */
  setItems(items) {
    const slides = [];

    for (const slide of items) {
      const $trigger = slide.$trigger;

      if ($trigger) {
        const dataset = $trigger.dataset || {};

        slide.src = dataset.src || $trigger.getAttribute("href") || slide.src;
        slide.type = dataset.type || slide.type;

        // Support items without `src`, e.g., when `data-fancybox` attribute added directly to `<img>` element
        if (!slide.src && $trigger instanceof HTMLImageElement) {
          slide.src = $trigger.currentSrc || slide.$trigger.src;
        }
      }

      // Check for thumbnail element
      let $thumb = slide.$thumb;

      if (!$thumb) {
        let origTarget = slide.$trigger && slide.$trigger.origTarget;

        if (origTarget) {
          if (origTarget instanceof HTMLImageElement) {
            $thumb = origTarget;
          } else {
            $thumb = origTarget.querySelector("img:not([aria-hidden])");
          }
        }

        if (!$thumb && slide.$trigger) {
          $thumb =
            slide.$trigger instanceof HTMLImageElement
              ? slide.$trigger
              : slide.$trigger.querySelector("img:not([aria-hidden])");
        }
      }

      slide.$thumb = $thumb || null;

      // Get thumbnail image source
      let thumb = slide.thumb;

      if (!thumb && $thumb) {
        thumb = $thumb.currentSrc || $thumb.src;

        if (!thumb && $thumb.dataset) {
          thumb = $thumb.dataset.lazySrc || $thumb.dataset.src;
        }
      }

      // Assume we have image, then use it as thumbnail
      if (!thumb && slide.type === "image") {
        thumb = slide.src;
      }

      slide.thumb = thumb || null;

      // Add empty caption to make things simpler
      slide.caption = slide.caption || "";

      slides.push(slide);
    }

    this.items = slides;
  }

  /**
   * Initialize main Carousel that will be used to display the content
   * @param {Array} slides
   */
  initCarousel() {
    this.Carousel = new _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_4__.Carousel(
      this.$carousel,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(
        true,
        {},
        {
          prefix: "",

          classNames: {
            viewport: "fancybox__viewport",
            track: "fancybox__track",
            slide: "fancybox__slide",
          },

          textSelection: true,
          preload: this.option("preload"),

          friction: 0.88,

          slides: this.items,
          initialPage: this.options.startIndex,
          slidesPerPage: 1,

          infiniteX: this.option("infinite"),
          infiniteY: true,

          l10n: this.option("l10n"),

          Dots: false,
          Navigation: {
            classNames: {
              main: "fancybox__nav",
              button: "carousel__button",

              next: "is-next",
              prev: "is-prev",
            },
          },

          Panzoom: {
            textSelection: true,

            panOnlyZoomed: () => {
              return (
                this.Carousel && this.Carousel.pages && this.Carousel.pages.length < 2 && !this.option("dragToClose")
              );
            },

            lockAxis: () => {
              if (this.Carousel) {
                let rez = "x";

                if (this.option("dragToClose")) {
                  rez += "y";
                }

                return rez;
              }
            },
          },

          on: {
            "*": (name, ...details) => this.trigger(`Carousel.${name}`, ...details),
            init: (carousel) => (this.Carousel = carousel),
            createSlide: this.onCreateSlide,
            settle: this.onSettle,
          },
        },

        this.option("Carousel")
      )
    );

    if (this.option("dragToClose")) {
      this.Carousel.Panzoom.on({
        // Stop further touch event handling if content is scaled
        touchMove: this.onTouchMove,

        // Update backdrop opacity depending on vertical distance
        afterTransform: this.onTransform,

        // Close instance if drag distance exceeds limit
        touchEnd: this.onTouchEnd,
      });
    }

    this.trigger("initCarousel");

    return this;
  }

  /**
   * Process `createSlide` event to create caption element inside new slide
   */
  onCreateSlide(carousel, slide) {
    let caption = slide.caption || "";

    if (typeof this.options.caption === "function") {
      caption = this.options.caption.call(this, this, this.Carousel, slide);
    }

    if (typeof caption === "string" && caption.length) {
      const $caption = document.createElement("div");
      const id = `fancybox__caption_${this.id}_${slide.index}`;

      $caption.className = "fancybox__caption";
      $caption.innerHTML = caption;
      $caption.setAttribute("id", id);

      slide.$caption = slide.$el.appendChild($caption);

      slide.$el.classList.add("has-caption");
      slide.$el.setAttribute("aria-labelledby", id);
    }
  }

  /**
   * Handle Carousel `settle` event
   */
  onSettle() {
    if (this.option("autoFocus")) {
      this.focus();
    }
  }

  /**
   * Handle focus event
   * @param {Event} event - Focus event
   */
  onFocus(event) {
    this.focus(event);
  }

  /**
   * Handle click event on the container
   * @param {Event} event - Click event
   */
  onClick(event) {
    if (event.defaultPrevented) {
      return;
    }

    let eventTarget = event.composedPath()[0];

    if (eventTarget.matches("[data-fancybox-close]")) {
      event.preventDefault();
      Fancybox.close(false, event);

      return;
    }

    if (eventTarget.matches("[data-fancybox-next]")) {
      event.preventDefault();
      Fancybox.next();

      return;
    }

    if (eventTarget.matches("[data-fancybox-prev]")) {
      event.preventDefault();
      Fancybox.prev();

      return;
    }

    if (!eventTarget.matches(_shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__.FOCUSABLE_ELEMENTS)) {
      document.activeElement.blur();
    }

    // Skip if clicked inside content area
    if (eventTarget.closest(".fancybox__content")) {
      return;
    }

    // Skip if text is selected
    if (getSelection().toString().length) {
      return;
    }

    if (this.trigger("click", event) === false) {
      return;
    }

    const action = this.option("click");

    switch (action) {
      case "close":
        this.close();
        break;
      case "next":
        this.next();
        break;
    }
  }

  /**
   * Handle panzoom `touchMove` event; Disable dragging if content of current slide is scaled
   */
  onTouchMove() {
    const panzoom = this.getSlide().Panzoom;

    return panzoom && panzoom.content.scale !== 1 ? false : true;
  }

  /**
   * Handle panzoom `touchEnd` event; close when quick flick up/down is detected
   * @param {Object} panzoom - Panzoom instance
   */
  onTouchEnd(panzoom) {
    const distanceY = panzoom.dragOffset.y;

    if (Math.abs(distanceY) >= 150 || (Math.abs(distanceY) >= 35 && panzoom.dragOffset.time < 350)) {
      if (this.option("hideClass")) {
        this.getSlide().hideClass = `fancybox-throwOut${panzoom.content.y < 0 ? "Up" : "Down"}`;
      }

      this.close();
    } else if (panzoom.lockAxis === "y") {
      panzoom.panTo({ y: 0 });
    }
  }

  /**
   * Handle `afterTransform` event; change backdrop opacity based on current y position of panzoom
   * @param {Object} panzoom - Panzoom instance
   */
  onTransform(panzoom) {
    const $backdrop = this.$backdrop;

    if ($backdrop) {
      const yPos = Math.abs(panzoom.content.y);
      const opacity = yPos < 1 ? "" : Math.max(0.33, Math.min(1, 1 - (yPos / panzoom.content.fitHeight) * 1.5));

      this.$container.style.setProperty("--fancybox-ts", opacity ? "0s" : "");
      this.$container.style.setProperty("--fancybox-opacity", opacity);
    }
  }

  /**
   * Handle `mousedown` event to mark that the mouse is in use
   */
  onMousedown() {
    if (this.state === "ready") {
      document.body.classList.add("is-using-mouse");
    }
  }

  /**
   * Handle `keydown` event; trap focus
   * @param {Event} event Keydown event
   */
  onKeydown(event) {
    if (Fancybox.getInstance().id !== this.id) {
      return;
    }

    document.body.classList.remove("is-using-mouse");

    const key = event.key;
    const keyboard = this.option("keyboard");

    if (!keyboard || event.ctrlKey || event.altKey || event.shiftKey) {
      return;
    }

    const target = event.composedPath()[0];

    const classList = document.activeElement && document.activeElement.classList;
    const isUIElement = classList && classList.contains("carousel__button");

    // Allow to close using Escape button
    if (key !== "Escape" && !isUIElement) {
      let ignoreElements =
        event.target.isContentEditable ||
        ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(target.nodeName) !== -1;

      if (ignoreElements) {
        return;
      }
    }

    if (this.trigger("keydown", key, event) === false) {
      return;
    }

    const action = keyboard[key];

    if (typeof this[action] === "function") {
      this[action]();
    }
  }

  /**
   * Get the active slide. This will be the first slide from the current page of the main carousel.
   */
  getSlide() {
    const carousel = this.Carousel;

    if (!carousel) return null;

    const page = carousel.page === null ? carousel.option("initialPage") : carousel.page;
    const pages = carousel.pages || [];

    if (pages.length && pages[page]) {
      return pages[page].slides[0];
    }

    return null;
  }

  /**
   * Place focus on the first focusable element inside current slide
   * @param {Event} [event] - Focus event
   */
  focus(event) {
    if (Fancybox.ignoreFocusChange) {
      return;
    }

    if (["init", "closing", "customClosing", "destroy"].indexOf(this.state) > -1) {
      return;
    }

    const $container = this.$container;
    const currentSlide = this.getSlide();
    const $currentSlide = currentSlide.state === "done" ? currentSlide.$el : null;

    // Skip if the DOM element that is currently in focus is already inside the current slide
    if ($currentSlide && $currentSlide.contains(document.activeElement)) {
      return;
    }

    if (event) {
      event.preventDefault();
    }

    Fancybox.ignoreFocusChange = true;

    const allFocusableElems = Array.from($container.querySelectorAll(_shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__.FOCUSABLE_ELEMENTS));

    let enabledElems = [];
    let $firstEl;

    for (let node of allFocusableElems) {
      // Enable element if it's visible and
      // is inside the current slide or is outside main carousel (for example, inside the toolbar)
      const isNodeVisible = node.offsetParent;
      const isNodeInsideCurrentSlide = $currentSlide && $currentSlide.contains(node);
      const isNodeOutsideCarousel = !this.Carousel.$viewport.contains(node);

      if (isNodeVisible && (isNodeInsideCurrentSlide || isNodeOutsideCarousel)) {
        enabledElems.push(node);

        if (node.dataset.origTabindex !== undefined) {
          node.tabIndex = node.dataset.origTabindex;
          node.removeAttribute("data-orig-tabindex");
        }

        if (
          node.hasAttribute("autoFocus") ||
          (!$firstEl && isNodeInsideCurrentSlide && !node.classList.contains("carousel__button"))
        ) {
          $firstEl = node;
        }
      } else {
        // Element is either hidden or is inside preloaded slide (e.g., not inside current slide, but next/prev)
        node.dataset.origTabindex =
          node.dataset.origTabindex === undefined ? node.getAttribute("tabindex") : node.dataset.origTabindex;

        node.tabIndex = -1;
      }
    }

    if (!event) {
      if (this.option("autoFocus") && $firstEl) {
        (0,_shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__.setFocusOn)($firstEl);
      } else if (enabledElems.indexOf(document.activeElement) < 0) {
        (0,_shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__.setFocusOn)($container);
      }
    } else {
      if (enabledElems.indexOf(event.target) > -1) {
        this.lastFocus = event.target;
      } else {
        if (this.lastFocus === $container) {
          (0,_shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__.setFocusOn)(enabledElems[enabledElems.length - 1]);
        } else {
          (0,_shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__.setFocusOn)($container);
        }
      }
    }

    this.lastFocus = document.activeElement;

    Fancybox.ignoreFocusChange = false;
  }

  /**
   * Hide vertical page scrollbar and adjust right padding value of `body` element to prevent content from shifting
   * (otherwise the `body` element may become wider and the content may expand horizontally).
   */
  hideScrollbar() {
    if (!_shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_1__.canUseDOM) {
      return;
    }

    const scrollbarWidth = window.innerWidth - document.documentElement.getBoundingClientRect().width;
    const id = "fancybox-style-noscroll";

    let $style = document.getElementById(id);

    if ($style) {
      return;
    }

    if (scrollbarWidth > 0) {
      $style = document.createElement("style");

      $style.id = id;
      $style.type = "text/css";
      $style.innerHTML = `.compensate-for-scrollbar {padding-right: ${scrollbarWidth}px;}`;

      document.getElementsByTagName("head")[0].appendChild($style);

      document.body.classList.add("compensate-for-scrollbar");
    }
  }

  /**
   * Stop hiding vertical page scrollbar
   */
  revealScrollbar() {
    document.body.classList.remove("compensate-for-scrollbar");

    const el = document.getElementById("fancybox-style-noscroll");

    if (el) {
      el.remove();
    }
  }

  /**
   * Remove content for given slide
   * @param {Object} slide - Carousel slide
   */
  clearContent(slide) {
    // * Clear previously added content and class name
    this.Carousel.trigger("removeSlide", slide);

    if (slide.$content) {
      slide.$content.remove();
      slide.$content = null;
    }

    if (slide.$closeButton) {
      slide.$closeButton.remove();
      slide.$closeButton = null;
    }

    if (slide._className) {
      slide.$el.classList.remove(slide._className);
    }
  }

  /**
   * Set new content for given slide
   * @param {Object} slide - Carousel slide
   * @param {HTMLElement|String} html - HTML element or string containing HTML code
   * @param {Object} [opts] - Options
   */
  setContent(slide, html, opts = {}) {
    let $content;

    const $el = slide.$el;

    if (html instanceof HTMLElement) {
      if (["img", "iframe", "video", "audio"].indexOf(html.nodeName.toLowerCase()) > -1) {
        $content = document.createElement("div");
        $content.appendChild(html);
      } else {
        $content = html;
      }
    } else {
      const $fragment = document.createRange().createContextualFragment(html);

      $content = document.createElement("div");
      $content.appendChild($fragment);
    }

    if (slide.filter && !slide.error) {
      $content = $content.querySelector(slide.filter);
    }

    if (!($content instanceof Element)) {
      this.setError(slide, "{{ELEMENT_NOT_FOUND}}");

      return;
    }

    // * Add class name indicating content type, for example `has-image`
    slide._className = `has-${opts.suffix || slide.type || "unknown"}`;

    $el.classList.add(slide._className);

    // * Set content
    $content.classList.add("fancybox__content");

    // Make sure that content is not hidden and will be visible
    if ($content.style.display === "none" || getComputedStyle($content).getPropertyValue("display") === "none") {
      $content.style.display = slide.display || this.option("defaultDisplay") || "flex";
    }

    if (slide.id) {
      $content.setAttribute("id", slide.id);
    }

    slide.$content = $content;

    $el.prepend($content);

    this.manageCloseButton(slide);

    if (slide.state !== "loading") {
      this.revealContent(slide);
    }

    return $content;
  }

  /**
   * Create close button if needed
   * @param {Object} slide
   */
  manageCloseButton(slide) {
    const position = slide.closeButton === undefined ? this.option("closeButton") : slide.closeButton;

    if (!position || (position === "top" && this.$closeButton)) {
      return;
    }

    const $btn = document.createElement("button");

    $btn.classList.add("carousel__button", "is-close");
    $btn.setAttribute("title", this.options.l10n.CLOSE);
    $btn.innerHTML = this.option("template.closeButton");

    $btn.addEventListener("click", (e) => this.close(e));

    if (position === "inside") {
      // Remove existing one to avoid scope issues
      if (slide.$closeButton) {
        slide.$closeButton.remove();
      }

      slide.$closeButton = slide.$content.appendChild($btn);
    } else {
      this.$closeButton = this.$container.insertBefore($btn, this.$container.firstChild);
    }
  }

  /**
   * Make content visible for given slide and optionally start CSS animation
   * @param {Object} slide - Carousel slide
   */
  revealContent(slide) {
    this.trigger("reveal", slide);

    slide.$content.style.visibility = "";

    // Add CSS class name that reveals content (default animation is "fadeIn")
    let showClass = false;

    if (
      !(
        slide.error ||
        slide.state === "loading" ||
        this.Carousel.prevPage !== null ||
        slide.index !== this.options.startIndex
      )
    ) {
      showClass = slide.showClass === undefined ? this.option("showClass") : slide.showClass;
    }

    if (!showClass) {
      this.done(slide);

      return;
    }

    slide.state = "animating";

    this.animateCSS(slide.$content, showClass, () => {
      this.done(slide);
    });
  }

  /**
   * Add class name to given HTML element and wait for `animationend` event to execute callback
   * @param {HTMLElement} $el
   * @param {String} className
   * @param {Function} callback - A callback to run
   */
  animateCSS($element, className, callback) {
    if ($element) {
      $element.dispatchEvent(new CustomEvent("animationend", { bubbles: true, cancelable: true }));
    }

    if (!$element || !className) {
      if (typeof callback === "function") {
        callback();
      }

      return;
    }

    const handleAnimationEnd = function (event) {
      if (event.currentTarget === this) {
        $element.removeEventListener("animationend", handleAnimationEnd);

        if (callback) {
          callback();
        }

        $element.classList.remove(className);
      }
    };

    $element.addEventListener("animationend", handleAnimationEnd);
    $element.classList.add(className);
  }

  /**
   * Mark given slide as `done`, e.g., content is loaded and displayed completely
   * @param {Object} slide - Carousel slide
   */
  done(slide) {
    slide.state = "done";

    this.trigger("done", slide);

    // Trigger focus for current slide (and ignore preloaded slides)
    const currentSlide = this.getSlide();

    if (currentSlide && slide.index === currentSlide.index && this.option("autoFocus")) {
      this.focus();
    }
  }

  /**
   * Set error message as slide content
   * @param {Object} slide - Carousel slide
   * @param {String} message - Error message, can contain HTML code and template variables
   */
  setError(slide, message) {
    slide.error = message;

    this.hideLoading(slide);
    this.clearContent(slide);

    // Create new content
    const div = document.createElement("div");
    div.classList.add("fancybox-error");
    div.innerHTML = this.localize(message || "<p>{{ERROR}}</p>");

    this.setContent(slide, div, { suffix: "error" });
  }

  /**
   * Create loading indicator inside given slide
   * @param {Object} slide - Carousel slide
   */
  showLoading(slide) {
    slide.state = "loading";

    slide.$el.classList.add("is-loading");

    let $spinner = slide.$el.querySelector(".fancybox__spinner");

    if ($spinner) {
      return;
    }

    $spinner = document.createElement("div");

    $spinner.classList.add("fancybox__spinner");
    $spinner.innerHTML = this.option("template.spinner");

    $spinner.addEventListener("click", () => {
      if (!this.Carousel.Panzoom.velocity) this.close();
    });

    slide.$el.prepend($spinner);
  }

  /**
   * Remove loading indicator from given slide
   * @param {Object} slide - Carousel slide
   */
  hideLoading(slide) {
    const $spinner = slide.$el && slide.$el.querySelector(".fancybox__spinner");

    if ($spinner) {
      $spinner.remove();

      slide.$el.classList.remove("is-loading");
    }

    if (slide.state === "loading") {
      this.trigger("load", slide);

      slide.state = "ready";
    }
  }

  /**
   * Slide carousel to next page
   */
  next() {
    const carousel = this.Carousel;

    if (carousel && carousel.pages.length > 1) {
      carousel.slideNext();
    }
  }

  /**
   * Slide carousel to previous page
   */
  prev() {
    const carousel = this.Carousel;

    if (carousel && carousel.pages.length > 1) {
      carousel.slidePrev();
    }
  }

  /**
   * Slide carousel to selected page with optional parameters
   * Examples:
   *    Fancybox.getInstance().jumpTo(2);
   *    Fancybox.getInstance().jumpTo(3, {friction: 0})
   * @param  {...any} args - Arguments for Carousel `slideTo` method
   */
  jumpTo(...args) {
    if (this.Carousel) this.Carousel.slideTo(...args);
  }

  /**
   * Start closing the current instance
   * @param {Event} [event] - Optional click event
   */
  close(event) {
    if (event) event.preventDefault();

    // First, stop further execution if this instance is already closing
    // (this can happen if, for example, user clicks close button multiple times really fast)
    if (["closing", "customClosing", "destroy"].includes(this.state)) {
      return;
    }

    // Allow callbacks and/or plugins to prevent closing
    if (this.trigger("shouldClose", event) === false) {
      return;
    }

    this.state = "closing";

    this.Carousel.Panzoom.destroy();

    this.detachEvents();

    this.trigger("closing", event);

    if (this.state === "destroy") {
      return;
    }

    // Trigger default CSS closing animation for backdrop and interface elements
    this.$container.setAttribute("aria-hidden", "true");

    this.$container.classList.add("is-closing");

    // Clear inactive slides
    const currentSlide = this.getSlide();

    this.Carousel.slides.forEach((slide) => {
      if (slide.$content && slide.index !== currentSlide.index) {
        this.Carousel.trigger("removeSlide", slide);
      }
    });

    // Start default closing animation
    if (this.state === "closing") {
      const hideClass = currentSlide.hideClass === undefined ? this.option("hideClass") : currentSlide.hideClass;

      this.animateCSS(
        currentSlide.$content,
        hideClass,
        () => {
          this.destroy();
        },
        true
      );
    }
  }

  /**
   * Clean up after closing fancybox
   */
  destroy() {
    if (this.state === "destroy") {
      return;
    }

    this.state = "destroy";

    this.trigger("destroy");

    const $trigger = this.option("placeFocusBack") ? this.getSlide().$trigger : null;

    // Destroy Carousel and then detach plugins;
    // * Note: this order allows plugins to receive `removeSlide` event
    this.Carousel.destroy();

    this.detachPlugins();

    this.Carousel = null;

    this.options = {};
    this.events = {};

    this.$container.remove();

    this.$container = this.$backdrop = this.$carousel = null;

    if ($trigger) {
      (0,_shared_utils_setFocusOn_js__WEBPACK_IMPORTED_MODULE_2__.setFocusOn)($trigger);
    }

    instances.delete(this.id);

    const nextInstance = Fancybox.getInstance();

    if (nextInstance) {
      nextInstance.focus();
      return;
    }

    document.documentElement.classList.remove("with-fancybox");
    document.body.classList.remove("is-using-mouse");

    this.revealScrollbar();
  }

  /**
   * Create new Fancybox instance with provided options
   * Example:
   *   Fancybox.show([{ src : 'https://lipsum.app/id/1/300x225' }]);
   * @param {Array} items - Gallery items
   * @param {Object} [options] - Optional custom options
   * @returns {Object} Fancybox instance
   */
  static show(items, options = {}) {
    return new Fancybox(items, options);
  }

  /**
   * Starts Fancybox if event target matches any opener or target is `trigger element`
   * @param {Event} event - Click event
   * @param {Object} [options] - Optional custom options
   */
  static fromEvent(event, options = {}) {
    //  Allow other scripts to prevent starting fancybox on click
    if (event.defaultPrevented) {
      return;
    }

    // Don't run if right-click
    if (event.button && event.button !== 0) {
      return;
    }

    // Ignore command/control + click
    if (event.ctrlKey || event.metaKey || event.shiftKey) {
      return;
    }

    const origTarget = event.composedPath()[0];

    let eventTarget = origTarget;

    // Support `trigger` element, e.g., start fancybox from different DOM element, for example,
    // to have one preview image for hidden image gallery
    let triggerGroupName;

    if (
      eventTarget.matches("[data-fancybox-trigger]") ||
      (eventTarget = eventTarget.closest("[data-fancybox-trigger]"))
    ) {
      triggerGroupName = eventTarget && eventTarget.dataset && eventTarget.dataset.fancyboxTrigger;
    }

    if (triggerGroupName) {
      const triggerItems = document.querySelectorAll(`[data-fancybox="${triggerGroupName}"]`);
      const triggerIndex = parseInt(eventTarget.dataset.fancyboxIndex, 10) || 0;

      eventTarget = triggerItems.length ? triggerItems[triggerIndex] : eventTarget;
    }

    if (!eventTarget) {
      eventTarget = origTarget;
    }

    // * Try to find matching openener
    let matchingOpener;
    let target;

    Array.from(Fancybox.openers.keys())
      .reverse()
      .some((opener) => {
        target = eventTarget;

        let found = false;

        try {
          if (target instanceof Element && (typeof opener === "string" || opener instanceof String)) {
            // Chain closest() to event.target to find and return the parent element,
            // regardless if clicking on the child elements (icon, label, etc)
            found = target.matches(opener) || (target = target.closest(opener));
          }
        } catch (error) {}

        if (found) {
          event.preventDefault();
          matchingOpener = opener;
          return true;
        }

        return false;
      });

    let rez = false;

    if (matchingOpener) {
      options.event = event;
      options.target = target;

      target.origTarget = origTarget;

      rez = Fancybox.fromOpener(matchingOpener, options);

      // Check if the mouse is being used
      // Waiting for better browser support for `:focus-visible` -
      // https://drafts.csswg.org/selectors-4/#the-focus-visible-pseudo
      const nextInstance = Fancybox.getInstance();

      if (nextInstance && nextInstance.state === "ready" && event.detail) {
        document.body.classList.add("is-using-mouse");
      }
    }

    return rez;
  }

  /**
   * Starts Fancybox using selector
   * @param {String} opener - Valid CSS selector string
   * @param {Object} [options] - Optional custom options
   */
  static fromOpener(opener, options = {}) {
    // Callback function called once for each group element that
    // 1) converts data attributes to boolean or JSON
    // 2) removes values that could cause issues
    const mapCallback = function (el) {
      const falseValues = ["false", "0", "no", "null", "undefined"];
      const trueValues = ["true", "1", "yes"];

      const dataset = Object.assign({}, el.dataset);
      const options = {};

      for (let [key, value] of Object.entries(dataset)) {
        if (key === "fancybox") {
          continue;
        }

        if (key === "width" || key === "height") {
          options[`_${key}`] = value;
        } else if (typeof value === "string" || value instanceof String) {
          if (falseValues.indexOf(value) > -1) {
            options[key] = false;
          } else if (trueValues.indexOf(options[key]) > -1) {
            options[key] = true;
          } else {
            try {
              options[key] = JSON.parse(value);
            } catch (e) {
              options[key] = value;
            }
          }
        } else {
          options[key] = value;
        }
      }

      if (el instanceof Element) {
        options.$trigger = el;
      }

      return options;
    };

    let items = [],
      index = options.startIndex || 0,
      target = options.target || null;

    // Get options
    // ===
    options = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, options, Fancybox.openers.get(opener));

    // Get matching nodes
    // ===
    const groupAll = options.groupAll === undefined ? false : options.groupAll;

    const groupAttr = options.groupAttr === undefined ? "data-fancybox" : options.groupAttr;
    const groupValue = groupAttr && target ? target.getAttribute(`${groupAttr}`) : "";

    if (!target || groupValue || groupAll) {
      const $root = options.root || (target ? target.getRootNode() : document.body);

      items = [].slice.call($root.querySelectorAll(opener));
    }

    if (target && !groupAll) {
      if (groupValue) {
        items = items.filter((el) => el.getAttribute(`${groupAttr}`) === groupValue);
      } else {
        items = [target];
      }
    }

    if (!items.length) {
      return false;
    }

    // Exit if current instance is triggered from the same element
    // ===
    const currentInstance = Fancybox.getInstance();

    if (currentInstance && items.indexOf(currentInstance.options.$trigger) > -1) {
      return false;
    }

    // Start Fancybox
    // ===

    // Get index of current item in the gallery
    index = target ? items.indexOf(target) : index;

    // Convert items in a format supported by fancybox
    items = items.map(mapCallback);

    // * Create new fancybox instance
    return new Fancybox(
      items,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, options, {
        startIndex: index,
        $trigger: target,
      })
    );
  }

  /**
   * Attach a click handler function that starts Fancybox to the selected items, as well as to all future matching elements.
   * @param {String} selector - Selector that should match trigger elements
   * @param {Object} [options] - Custom options
   */
  static bind(selector, options = {}) {
    function attachClickEvent() {
      document.body.addEventListener("click", Fancybox.fromEvent, false);
    }

    if (!_shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_1__.canUseDOM) {
      return;
    }

    if (!Fancybox.openers.size) {
      if (/complete|interactive|loaded/.test(document.readyState)) {
        attachClickEvent();
      } else {
        document.addEventListener("DOMContentLoaded", attachClickEvent);
      }
    }

    Fancybox.openers.set(selector, options);
  }

  /**
   * Remove the click handler that was attached with `bind()`
   * @param {String} selector - A selector which should match the one originally passed to .bind()
   */
  static unbind(selector) {
    Fancybox.openers.delete(selector);

    if (!Fancybox.openers.size) {
      Fancybox.destroy();
    }
  }

  /**
   * Immediately destroy all instances (without closing animation) and clean up all bindings..
   */
  static destroy() {
    let fb;

    while ((fb = Fancybox.getInstance())) {
      fb.destroy();
    }

    Fancybox.openers = new Map();

    document.body.removeEventListener("click", Fancybox.fromEvent, false);
  }

  /**
   * Retrieve instance by identifier or the top most instance, if identifier is not provided
   * @param {String|Numeric} [id] - Optional instance identifier
   */
  static getInstance(id) {
    if (id) {
      return instances.get(id);
    }

    const instance = Array.from(instances.values())
      .reverse()
      .find((instance) => {
        if (!["closing", "customClosing", "destroy"].includes(instance.state)) {
          return instance;
        }

        return false;
      });

    return instance || null;
  }

  /**
   * Close all or topmost currently active instance.
   * @param {boolean} [all] - All or only topmost active instance
   * @param {any} [arguments] - Optional data
   */
  static close(all = true, args) {
    if (all) {
      for (const instance of instances.values()) {
        instance.close(args);
      }
    } else {
      const instance = Fancybox.getInstance();

      if (instance) {
        instance.close(args);
      }
    }
  }

  /**
   * Slide topmost currently active instance to next page
   */
  static next() {
    const instance = Fancybox.getInstance();

    if (instance) {
      instance.next();
    }
  }

  /**
   * Slide topmost currently active instance to previous page
   */
  static prev() {
    const instance = Fancybox.getInstance();

    if (instance) {
      instance.prev();
    }
  }
}

// Expose version
Fancybox.version = "__VERSION__";

// Expose defaults
Fancybox.defaults = defaults;

// Expose openers
Fancybox.openers = new Map();

// Add default plugins
Fancybox.Plugins = _plugins_index_js__WEBPACK_IMPORTED_MODULE_5__.Plugins;

// Auto init with default options
Fancybox.bind("[data-fancybox]");

// Prepare plugins
for (const [key, Plugin] of Object.entries(Fancybox.Plugins || {})) {
  if (typeof Plugin.create === "function") {
    Plugin.create(Fancybox);
  }
}




/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/l10n/en.js":
/*!*************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/l10n/en.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__) {

/* harmony default export */ __webpack_exports__["default"] = ({
  CLOSE: "Close",
  NEXT: "Next",
  PREV: "Previous",
  MODAL: "You can close this modal content with the ESC key",
  ERROR: "Something Went Wrong, Please Try Again Later",
  IMAGE_ERROR: "Image Not Found",
  ELEMENT_NOT_FOUND: "HTML Element Not Found",
  AJAX_NOT_FOUND: "Error Loading AJAX : Not Found",
  AJAX_FORBIDDEN: "Error Loading AJAX : Forbidden",
  IFRAME_ERROR: "Error Loading Page",
  TOGGLE_ZOOM: "Toggle zoom level",
  TOGGLE_THUMBS: "Toggle thumbnails",
  TOGGLE_SLIDESHOW: "Toggle slideshow",
  TOGGLE_FULLSCREEN: "Toggle full-screen mode",
  DOWNLOAD: "Download",
});


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Hash/Hash.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/plugins/Hash/Hash.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Hash": function() { return /* binding */ Hash; }
/* harmony export */ });
/* harmony import */ var _shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/canUseDOM.js */ "../node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js");


class Hash {
  constructor(fancybox) {
    this.fancybox = fancybox;

    for (const methodName of ["onChange", "onClosing"]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      initCarousel: this.onChange,
      "Carousel.change": this.onChange,
      closing: this.onClosing,
    };

    this.hasCreatedHistory = false;
    this.origHash = "";
    this.timer = null;
  }

  /**
   * Process `Carousel.ready` and `Carousel.change` events to update URL hash
   * @param {Object} fancybox
   * @param {Object} carousel
   */
  onChange(fancybox) {
    const carousel = fancybox.Carousel;

    if (this.timer) {
      clearTimeout(this.timer);
    }

    const firstRun = carousel.prevPage === null;
    const currentSlide = fancybox.getSlide();

    const currentHash = new URL(document.URL).hash;

    let newHash = false;

    if (currentSlide.slug) {
      newHash = "#" + currentSlide.slug;
    } else {
      const dataset = currentSlide.$trigger && currentSlide.$trigger.dataset;
      const slug = fancybox.option("slug") || (dataset && dataset.fancybox);

      if (slug && slug.length && slug !== "true") {
        newHash = "#" + slug + (carousel.slides.length > 1 ? "-" + (currentSlide.index + 1) : "");
      }
    }

    if (firstRun) {
      this.origHash = currentHash !== newHash ? currentHash : "";
    }

    if (newHash && currentHash !== newHash) {
      this.timer = setTimeout(() => {
        try {
          window.history[firstRun ? "pushState" : "replaceState"](
            {},
            document.title,
            window.location.pathname + window.location.search + newHash
          );

          if (firstRun) {
            this.hasCreatedHistory = true;
          }
        } catch (e) {}
      }, 300);
    }
  }

  /**
   * Process `closing` event to clean up
   */
  onClosing() {
    if (this.timer) {
      clearTimeout(this.timer);
    }

    // Skip if closing is triggered by pressing  browser back button or by changing hash manually
    if (this.hasSilentClose === true) {
      return;
    }

    // Restore original url
    try {
      window.history.replaceState(
        {},
        document.title,
        window.location.pathname + window.location.search + (this.origHash || "")
      );

      return;
    } catch (e) {}
  }

  attach(fancybox) {
    fancybox.on(this.events);
  }

  detach(fancybox) {
    fancybox.off(this.events);
  }

  /**
   * Start fancybox from current URL hash,
   * this will be called on page load OR/AND after changing URL hash
   * @param {Class} Fancybox
   */
  static startFromUrl() {
    const Fancybox = Hash.Fancybox;

    if (!Fancybox || Fancybox.getInstance() || Fancybox.defaults.Hash === false) {
      return;
    }

    const { hash, slug, index } = Hash.getParsedURL();

    if (!slug) {
      return;
    }

    // Support custom slug
    // ===
    let selectedElem = document.querySelector(`[data-slug="${hash}"]`);

    if (selectedElem) {
      selectedElem.dispatchEvent(new CustomEvent("click", { bubbles: true, cancelable: true }));
    }

    if (Fancybox.getInstance()) {
      return;
    }

    // If elements are not found by custom slug, use URL hash value as group name
    // ===
    const groupElems = document.querySelectorAll(`[data-fancybox="${slug}"]`);

    if (!groupElems.length) {
      return;
    }

    if (index === null && groupElems.length === 1) {
      selectedElem = groupElems[0];
    } else if (index) {
      selectedElem = groupElems[index - 1];
    }

    if (selectedElem) {
      selectedElem.dispatchEvent(new CustomEvent("click", { bubbles: true, cancelable: true }));
    }
  }

  /**
   * Handle `hash` change, change gallery item to current index or start/close current instance
   */
  static onHashChange() {
    const { slug, index } = Hash.getParsedURL();

    const Fancybox = Hash.Fancybox;
    const instance = Fancybox && Fancybox.getInstance();

    if (instance && instance.plugins.Hash) {
      // Check if hash matches currently active gallery
      if (slug) {
        const carousel = instance.Carousel;

        /**
         * Support manually opened gallery
         */
        if (slug === instance.option("slug")) {
          return carousel.slideTo(index - 1);
        }

        /**
         * Check if URL hash matches `data-slug` value of active element
         */
        for (let slide of carousel.slides) {
          if (slide.slug && slide.slug === slug) {
            return carousel.slideTo(slide.index);
          }
        }

        /**
         * Check if URL hash matches `data-fancybox` value of active element
         */
        const slide = instance.getSlide();
        const dataset = slide.$trigger && slide.$trigger.dataset;

        if (dataset && dataset.fancybox === slug) {
          return carousel.slideTo(index - 1);
        }
      }

      /**
       * Close if no matching element found
       */
      instance.plugins.Hash.hasSilentClose = true;

      instance.close();
    }

    /**
     * Attempt to start
     */
    Hash.startFromUrl();
  }

  /**
   * Add event bindings that will start new Fancybox instance based in the current URL
   */
  static create(Fancybox) {
    Hash.Fancybox = Fancybox;

    function proceed() {
      window.addEventListener("hashchange", Hash.onHashChange, false);

      Hash.startFromUrl();
    }

    if (_shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_0__.canUseDOM) {
      window.requestAnimationFrame(() => {
        if (/complete|interactive|loaded/.test(document.readyState)) {
          proceed();
        } else {
          document.addEventListener("DOMContentLoaded", proceed);
        }
      });
    }
  }

  static destroy() {
    window.removeEventListener("hashchange", Hash.onHashChange, false);
  }

  /**
   * Helper method to split URL hash into useful pieces
   */
  static getParsedURL() {
    const hash = window.location.hash.substr(1),
      tmp = hash.split("-"),
      index = tmp.length > 1 && /^\+?\d+$/.test(tmp[tmp.length - 1]) ? parseInt(tmp.pop(-1), 10) || null : null,
      slug = tmp.join("-");

    return {
      hash,
      slug,
      index,
    };
  }
}


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Html/Html.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/plugins/Html/Html.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Html": function() { return /* binding */ Html; }
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");


const buildURLQuery = (src, obj) => {
  const url = new URL(src);
  const params = new URLSearchParams(url.search);

  let rez = new URLSearchParams();

  for (const [key, value] of [...params, ...Object.entries(obj)]) {
    // Youtube
    if (key === "t") {
      rez.set("start", parseInt(value));
    } else {
      rez.set(key, value);
    }
  }

  // Convert to 'foo=1&bar=2&baz=3'
  rez = rez.toString();

  // Vimeo
  // https://vimeo.zendesk.com/hc/en-us/articles/360000121668-Starting-playback-at-a-specific-timecode
  let matches = src.match(/#t=((.*)?\d+s)/);

  if (matches) {
    rez += `#t=${matches[1]}`;
  }

  return rez;
};

const defaults = {
  // General options for any video content (Youtube, Vimeo, HTML5 video)
  video: {
    autoplay: true,
    ratio: 16 / 9,
  },
  // Youtube embed parameters
  youtube: {
    autohide: 1,
    fs: 1,
    rel: 0,
    hd: 1,
    wmode: "transparent",
    enablejsapi: 1,
    html5: 1,
  },
  // Vimeo embed parameters
  vimeo: {
    hd: 1,
    show_title: 1,
    show_byline: 1,
    show_portrait: 0,
    fullscreen: 1,
  },
  // HTML5 video parameters
  html5video: {
    tpl: `<video class="fancybox__html5video" playsinline controls controlsList="nodownload" poster="{{poster}}">
  <source src="{{src}}" type="{{format}}" />Sorry, your browser doesn't support embedded videos.</video>`,
    format: "",
  },
};

class Html {
  constructor(fancybox) {
    this.fancybox = fancybox;

    for (const methodName of [
      "onInit",
      "onReady",

      "onCreateSlide",
      "onRemoveSlide",

      "onSelectSlide",
      "onUnselectSlide",

      "onRefresh",

      // For communication with iframed video (youtube/vimeo)
      "onMessage",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      init: this.onInit,
      ready: this.onReady,

      "Carousel.createSlide": this.onCreateSlide,
      "Carousel.removeSlide": this.onRemoveSlide,

      "Carousel.selectSlide": this.onSelectSlide,
      "Carousel.unselectSlide": this.onUnselectSlide,

      "Carousel.refresh": this.onRefresh,
    };
  }

  /**
   * Check if each gallery item has type when fancybox starts
   */
  onInit() {
    for (const slide of this.fancybox.items) {
      this.processType(slide);
    }
  }

  /**
   * Set content type for the slide
   * @param {Object} slide
   */
  processType(slide) {
    // Add support for `new Fancybox({items : [{html : 'smth'}]});`
    if (slide.html) {
      slide.src = slide.html;
      slide.type = "html";

      delete slide.html;

      return;
    }

    const src = slide.src || "";

    let type = slide.type || this.fancybox.options.type,
      rez = null;

    if (src && typeof src !== "string") {
      return;
    }

    if (
      (rez = src.match(
        /(?:youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(?:watch\?(?:.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(?:.*)|[\w-]{11}|\?listType=(?:.*)&list=(?:.*))(?:.*)/i
      ))
    ) {
      const params = buildURLQuery(src, this.fancybox.option("Html.youtube"));
      const videoId = encodeURIComponent(rez[1]);

      slide.videoId = videoId;
      slide.src = `https://www.youtube-nocookie.com/embed/${videoId}?${params}`;
      slide.thumb = slide.thumb || `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`;
      slide.vendor = "youtube";

      type = "video";
    } else if ((rez = src.match(/^.+vimeo.com\/(?:\/)?([\d]+)(.*)?/))) {
      const params = buildURLQuery(src, this.fancybox.option("Html.vimeo"));
      const videoId = encodeURIComponent(rez[1]);

      slide.videoId = videoId;
      slide.src = `https://player.vimeo.com/video/${videoId}?${params}`;
      slide.vendor = "vimeo";

      type = "video";
    } else if (
      (rez = src.match(
        /(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:(?:(?:maps\/(?:place\/(?:.*)\/)?\@(.*),(\d+.?\d+?)z))|(?:\?ll=))(.*)?/i
      ))
    ) {
      slide.src = `//maps.google.${rez[1]}/?ll=${(rez[2]
        ? rez[2] + "&z=" + Math.floor(rez[3]) + (rez[4] ? rez[4].replace(/^\//, "&") : "")
        : rez[4] + ""
      ).replace(/\?/, "&")}&output=${rez[4] && rez[4].indexOf("layer=c") > 0 ? "svembed" : "embed"}`;

      type = "map";
    } else if ((rez = src.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:maps\/search\/)(.*)/i))) {
      slide.src = `//maps.google.${rez[1]}/maps?q=${rez[2].replace("query=", "q=").replace("api=1", "")}&output=embed`;

      type = "map";
    }

    // Guess content type
    if (!type) {
      if (src.charAt(0) === "#") {
        type = "inline";
      } else if ((rez = src.match(/\.(mp4|mov|ogv|webm)((\?|#).*)?$/i))) {
        type = "html5video";

        slide.format = slide.format || "video/" + (rez[1] === "ogv" ? "ogg" : rez[1]);
      } else if (src.match(/(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i)) {
        type = "image";
      } else if (src.match(/\.(pdf)((\?|#).*)?$/i)) {
        type = "pdf";
      }
    }

    slide.type = type || this.fancybox.option("defaultType", "image");

    if (type === "html5video" || type === "video") {
      slide.video = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, this.fancybox.option("Html.video"), slide.video);

      if (slide._width && slide._height) {
        slide.ratio = parseFloat(slide._width) / parseFloat(slide._height);
      } else {
        slide.ratio = slide.ratio || slide.video.ratio || defaults.video.ratio;
      }
    }
  }

  /**
   * Start loading content when Fancybox is ready
   */
  onReady() {
    this.fancybox.Carousel.slides.forEach((slide) => {
      if (slide.$el) {
        this.setContent(slide);

        if (slide.index === this.fancybox.getSlide().index) {
          this.playVideo(slide);
        }
      }
    });
  }

  /**
   * Process `Carousel.createSlide` event to create image content
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onCreateSlide(fancybox, carousel, slide) {
    if (this.fancybox.state !== "ready") {
      return;
    }

    this.setContent(slide);
  }

  /**
   * Retrieve and set slide content
   * @param {Object} slide
   */
  loadInlineContent(slide) {
    let $content;

    if (slide.src instanceof HTMLElement) {
      $content = slide.src;
    } else if (typeof slide.src === "string") {
      const tmp = slide.src.split("#", 2);
      const id = tmp.length === 2 && tmp[0] === "" ? tmp[1] : tmp[0];

      $content = document.getElementById(id);
    }

    if ($content) {
      if (slide.type === "clone" || $content.$placeHolder) {
        $content = $content.cloneNode(true);
        let attrId = $content.getAttribute("id");

        attrId = attrId ? `${attrId}--clone` : `clone-${this.fancybox.id}-${slide.index}`;

        $content.setAttribute("id", attrId);
      } else {
        const $placeHolder = document.createElement("div");
        $placeHolder.classList.add("fancybox-placeholder");
        $content.parentNode.insertBefore($placeHolder, $content);
        $content.$placeHolder = $placeHolder;
      }

      this.fancybox.setContent(slide, $content);
    } else {
      this.fancybox.setError(slide, "{{ELEMENT_NOT_FOUND}}");
    }
  }

  /**
   * Makes AJAX request and sets response as slide content
   * @param {Object} slide
   */
  loadAjaxContent(slide) {
    const fancybox = this.fancybox;
    const xhr = new XMLHttpRequest();

    fancybox.showLoading(slide);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (fancybox.state === "ready") {
          fancybox.hideLoading(slide);

          if (xhr.status === 200) {
            fancybox.setContent(slide, xhr.responseText);
          } else {
            fancybox.setError(slide, xhr.status === 404 ? "{{AJAX_NOT_FOUND}}" : "{{AJAX_FORBIDDEN}}");
          }
        }
      }
    };

    xhr.open("GET", slide.src);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(slide.ajax || null);

    slide.xhr = xhr;
  }

  /**
   * Creates iframe as slide content, preloads if needed before displaying
   * @param {Object} slide
   */
  loadIframeContent(slide) {
    const fancybox = this.fancybox;
    const $iframe = document.createElement("iframe");

    $iframe.className = "fancybox__iframe";

    $iframe.setAttribute("id", `fancybox__iframe_${fancybox.id}_${slide.index}`);

    $iframe.setAttribute("allow", "autoplay; fullscreen");
    $iframe.setAttribute("scrolling", "auto");

    slide.$iframe = $iframe;

    if (slide.type !== "iframe" || slide.preload === false) {
      $iframe.setAttribute("src", slide.src);

      this.fancybox.setContent(slide, $iframe);

      this.resizeIframe(slide);

      return;
    }

    fancybox.showLoading(slide);

    const $content = document.createElement("div");
    $content.style.visibility = "hidden";

    this.fancybox.setContent(slide, $content);

    $content.appendChild($iframe);

    $iframe.onerror = () => {
      fancybox.setError(slide, "{{IFRAME_ERROR}}");
    };

    $iframe.onload = () => {
      fancybox.hideLoading(slide);

      let isFirstLoad = false;

      if (!$iframe.isReady) {
        $iframe.isReady = true;
        isFirstLoad = true;
      }

      if (!$iframe.src.length) {
        return;
      }

      $iframe.parentNode.style.visibility = "";

      this.resizeIframe(slide);

      if (isFirstLoad) {
        fancybox.revealContent(slide);
      }
    };

    $iframe.setAttribute("src", slide.src);
  }

  /**
   * Set CSS max/min width/height properties of the content to have the correct aspect ratio
   * @param {Object} slide
   */
  setAspectRatio(slide) {
    const $content = slide.$content;
    const ratio = slide.ratio;

    if (!$content) {
      return;
    }

    let width = slide._width;
    let height = slide._height;

    if (ratio || (width && height)) {
      Object.assign($content.style, {
        width: width && height ? "100%" : "",
        height: width && height ? "100%" : "",
        maxWidth: "",
        maxHeight: "",
      });

      let maxWidth = $content.offsetWidth;
      let maxHeight = $content.offsetHeight;

      width = width || maxWidth;
      height = height || maxHeight;

      // Resize to fit
      if (width > maxWidth || height > maxHeight) {
        let maxRatio = Math.min(maxWidth / width, maxHeight / height);

        width = width * maxRatio;
        height = height * maxRatio;
      }

      // Recheck ratio
      if (Math.abs(width / height - ratio) > 0.01) {
        if (ratio < width / height) {
          width = height * ratio;
        } else {
          height = width / ratio;
        }
      }

      Object.assign($content.style, {
        width: `${width}px`,
        height: `${height}px`,
      });
    }
  }

  /**
   * Adjust the width and height of the iframe according to the content dimensions, or defined sizes
   * @param {Object} slide
   */
  resizeIframe(slide) {
    const $iframe = slide.$iframe;

    if (!$iframe) {
      return;
    }

    let width_ = slide._width || 0;
    let height_ = slide._height || 0;

    if (width_ && height_) {
      slide.autoSize = false;
    }

    const $parent = $iframe.parentNode;
    const parentStyle = $parent && $parent.style;

    if (slide.preload !== false && slide.autoSize !== false && parentStyle) {
      try {
        const compStyles = window.getComputedStyle($parent),
          paddingX = parseFloat(compStyles.paddingLeft) + parseFloat(compStyles.paddingRight),
          paddingY = parseFloat(compStyles.paddingTop) + parseFloat(compStyles.paddingBottom);

        const document = $iframe.contentWindow.document,
          $html = document.getElementsByTagName("html")[0],
          $body = document.body;

        // Allow content to expand horizontally
        parentStyle.width = "";

        // Get rid of vertical scrollbar
        $body.style.overflow = "hidden";

        width_ = width_ || $html.scrollWidth + paddingX;

        parentStyle.width = `${width_}px`;

        $body.style.overflow = "";

        parentStyle.flex = "0 0 auto";
        parentStyle.height = `${$body.scrollHeight}px`;

        height_ = $html.scrollHeight + paddingY;
      } catch (error) {
        //
      }
    }

    if (width_ || height_) {
      const newStyle = {
        flex: "0 1 auto",
      };

      if (width_) {
        newStyle.width = `${width_}px`;
      }

      if (height_) {
        newStyle.height = `${height_}px`;
      }

      Object.assign(parentStyle, newStyle);
    }
  }

  /**
   * Process `Carousel.onRefresh` event,
   * trigger iframe autosizing and set content aspect ratio for each slide
   * @param {Object} fancybox
   * @param {Object} carousel
   */
  onRefresh(fancybox, carousel) {
    carousel.slides.forEach((slide) => {
      if (!slide.$el) {
        return;
      }

      if (slide.$iframe) {
        this.resizeIframe(slide);
      }

      if (slide.ratio) {
        this.setAspectRatio(slide);
      }
    });
  }

  /**
   * Process `Carousel.onCreateSlide` event to set content
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  setContent(slide) {
    if (!slide || slide.isDom) {
      return;
    }

    switch (slide.type) {
      case "html":
        this.fancybox.setContent(slide, slide.src);
        break;

      case "html5video":
        this.fancybox.setContent(
          slide,
          this.fancybox
            .option("Html.html5video.tpl")
            .replace(/\{\{src\}\}/gi, slide.src)
            .replace("{{format}}", slide.format || (slide.html5video && slide.html5video.format) || "")
            .replace("{{poster}}", slide.poster || slide.thumb || "")
        );

        break;

      case "inline":
      case "clone":
        this.loadInlineContent(slide);
        break;

      case "ajax":
        this.loadAjaxContent(slide);
        break;

      case "pdf":
      case "video":
      case "map":
        slide.preload = false;

      case "iframe":
        this.loadIframeContent(slide);

        break;
    }

    if (slide.ratio) {
      this.setAspectRatio(slide);
    }
  }

  /**
   * Process `Carousel.onSelectSlide` event to start video
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onSelectSlide(fancybox, carousel, slide) {
    if (fancybox.state === "ready") {
      this.playVideo(slide);
    }
  }

  /**
   * Attempts to begin playback of the media
   * @param {Object} slide
   */
  playVideo(slide) {
    if (slide.type === "html5video" && slide.video.autoplay) {
      try {
        const $video = slide.$el.querySelector("video");

        if ($video) {
          const promise = $video.play();

          if (promise !== undefined) {
            promise
              .then(() => {
                // Autoplay started
              })
              .catch((error) => {
                // Autoplay was prevented.
                $video.muted = true;
                $video.play();
              });
          }
        }
      } catch (err) {}
    }

    if (slide.type !== "video" || !(slide.$iframe && slide.$iframe.contentWindow)) {
      return;
    }

    // This function will be repeatedly called to check
    // if video iframe has been loaded to send message to start the video
    const poller = () => {
      if (slide.state === "done" && slide.$iframe && slide.$iframe.contentWindow) {
        let command;

        if (slide.$iframe.isReady) {
          if (slide.video && slide.video.autoplay) {
            if (slide.vendor == "youtube") {
              command = {
                event: "command",
                func: "playVideo",
              };
            } else {
              command = {
                method: "play",
                value: "true",
              };
            }
          }

          if (command) {
            slide.$iframe.contentWindow.postMessage(JSON.stringify(command), "*");
          }

          return;
        }

        if (slide.vendor === "youtube") {
          command = {
            event: "listening",
            id: slide.$iframe.getAttribute("id"),
          };

          slide.$iframe.contentWindow.postMessage(JSON.stringify(command), "*");
        }
      }

      slide.poller = setTimeout(poller, 250);
    };

    poller();
  }

  /**
   * Process `Carousel.onUnselectSlide` event to pause video
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onUnselectSlide(fancybox, carousel, slide) {
    if (slide.type === "html5video") {
      try {
        slide.$el.querySelector("video").pause();
      } catch (error) {}

      return;
    }

    let command = false;

    if (slide.vendor == "vimeo") {
      command = {
        method: "pause",
        value: "true",
      };
    } else if (slide.vendor === "youtube") {
      command = {
        event: "command",
        func: "pauseVideo",
      };
    }

    if (command && slide.$iframe && slide.$iframe.contentWindow) {
      slide.$iframe.contentWindow.postMessage(JSON.stringify(command), "*");
    }

    clearTimeout(slide.poller);
  }

  /**
   * Process `Carousel.onRemoveSlide` event to do clean up
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onRemoveSlide(fancybox, carousel, slide) {
    // Abort ajax request if exists
    if (slide.xhr) {
      slide.xhr.abort();
      slide.xhr = null;
    }

    // Unload iframe content if exists
    if (slide.$iframe) {
      slide.$iframe.onload = slide.$iframe.onerror = null;

      slide.$iframe.src = "//about:blank";
      slide.$iframe = null;
    }

    // Clear inline content
    const $content = slide.$content;

    if (slide.type === "inline" && $content) {
      $content.classList.remove("fancybox__content");

      if ($content.style.display !== "none") {
        $content.style.display = "none";
      }
    }

    if (slide.$closeButton) {
      slide.$closeButton.remove();
      slide.$closeButton = null;
    }

    const $placeHolder = $content && $content.$placeHolder;

    if ($placeHolder) {
      $placeHolder.parentNode.insertBefore($content, $placeHolder);
      $placeHolder.remove();
      $content.$placeHolder = null;
    }
  }

  /**
   * Process `window.message` event to mark video iframe element as `ready`
   * @param {Object} e - Event
   */
  onMessage(e) {
    try {
      let data = JSON.parse(e.data);

      if (e.origin === "https://player.vimeo.com") {
        if (data.event === "ready") {
          for (let $iframe of document.getElementsByClassName("fancybox__iframe")) {
            if ($iframe.contentWindow === e.source) {
              $iframe.isReady = 1;
            }
          }
        }
      } else if (e.origin === "https://www.youtube-nocookie.com") {
        if (data.event === "onReady") {
          document.getElementById(data.id).isReady = 1;
        }
      }
    } catch (ex) {}
  }

  attach() {
    this.fancybox.on(this.events);

    window.addEventListener("message", this.onMessage, false);
  }

  detach() {
    this.fancybox.off(this.events);

    window.removeEventListener("message", this.onMessage, false);
  }
}

// Expose defaults
Html.defaults = defaults;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Image/Image.js":
/*!*************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/plugins/Image/Image.js ***!
  \*************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Image": function() { return /* binding */ Image; }
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../Panzoom/Panzoom.js */ "../node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js");




const defaults = {
  // Class name for slide element indicating that content can be zoomed in
  canZoomInClass: "can-zoom_in",

  // Class name for slide element indicating that content can be zoomed out
  canZoomOutClass: "can-zoom_out",

  // Do zoom animation from thumbnail image when starting or closing fancybox
  zoom: true,

  // Animate opacity while zooming
  zoomOpacity: "auto", // "auto" | true | false,

  // Zoom animation friction
  zoomFriction: 0.82,

  // Disable zoom animation if thumbnail is visible only partly
  ignoreCoveredThumbnail: false,

  // Enable guestures
  touch: true,

  // Action to be performed when user clicks on the image
  click: "toggleZoom", // "toggleZoom" | "next" | "close" | null

  // Action to be performed when double-click event is detected on the image
  doubleClick: null, // "toggleZoom" | null

  // Action to be performed when user rotates a wheel button on a pointing device
  wheel: "zoom", // "zoom" | "slide" | "close" | null

  // How image should be resized to fit its container
  fit: "contain", // "contain" | "contain-w" | "cover"

  // Should create wrapping element around the image
  wrap: false,

  // Custom Panzoom options
  Panzoom: {
    ratio: 1,
  },
};

class Image {
  constructor(fancybox) {
    this.fancybox = fancybox;

    for (const methodName of [
      // Fancybox
      "onReady",
      "onClosing",
      "onDone",

      // Fancybox.Carousel
      "onPageChange",
      "onCreateSlide",
      "onRemoveSlide",

      // Image load/error
      "onImageStatusChange",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      ready: this.onReady,
      closing: this.onClosing,
      done: this.onDone,

      "Carousel.change": this.onPageChange,
      "Carousel.createSlide": this.onCreateSlide,
      "Carousel.removeSlide": this.onRemoveSlide,
    };
  }

  /**
   * Handle `ready` event to start loading content
   */
  onReady() {
    this.fancybox.Carousel.slides.forEach((slide) => {
      if (slide.$el) {
        this.setContent(slide);
      }
    });
  }

  /**
   * Handle `done` event to update cursor
   * @param {Object} fancybox
   * @param {Object} slide
   */
  onDone(fancybox, slide) {
    this.handleCursor(slide);
  }

  /**
   * Handle `closing` event to clean up all slides and to start zoom-out animation
   * @param {Object} fancybox
   */
  onClosing(fancybox) {
    clearTimeout(this.clickTimer);
    this.clickTimer = null;

    // Remove events
    fancybox.Carousel.slides.forEach((slide) => {
      if (slide.$image) {
        slide.state = "destroy";
      }

      if (slide.Panzoom) {
        slide.Panzoom.detachEvents();
      }
    });

    // If possible, start the zoom animation, it will interrupt the default closing process
    if (this.fancybox.state === "closing" && this.canZoom(fancybox.getSlide())) {
      this.zoomOut();
    }
  }

  /**
   * Process `Carousel.createSlide` event to create image content
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onCreateSlide(fancybox, carousel, slide) {
    if (this.fancybox.state !== "ready") {
      return;
    }

    this.setContent(slide);
  }

  /**
   * Handle `Carousel.removeSlide` event to do clean up the slide
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onRemoveSlide(fancybox, carousel, slide) {
    if (slide.$image) {
      slide.$el.classList.remove(fancybox.option("Image.canZoomInClass"));

      slide.$image.remove();
      slide.$image = null;
    }

    if (slide.Panzoom) {
      slide.Panzoom.destroy();
      slide.Panzoom = null;
    }

    if (slide.$el && slide.$el.dataset) {
      delete slide.$el.dataset.imageFit;
    }
  }

  /**
   * Build DOM elements and add event listeners
   * @param {Object} slide
   */
  setContent(slide) {
    // Check if this slide should contain an image
    if (slide.isDom || slide.html || (slide.type && slide.type !== "image")) {
      return;
    }

    if (slide.$image) {
      return;
    }

    slide.type = "image";
    slide.state = "loading";

    // * Build layout
    // Container
    const $content = document.createElement("div");
    $content.style.visibility = "hidden";

    // Image element
    const $image = document.createElement("img");

    $image.addEventListener("load", (event) => {
      event.stopImmediatePropagation();

      this.onImageStatusChange(slide);
    });

    $image.addEventListener("error", () => {
      this.onImageStatusChange(slide);
    });

    $image.src = slide.src;
    $image.alt = "";
    $image.draggable = false;

    $image.classList.add("fancybox__image");

    if (slide.srcset) {
      $image.setAttribute("srcset", slide.srcset);
    }

    if (slide.sizes) {
      $image.setAttribute("sizes", slide.sizes);
    }

    slide.$image = $image;

    const shouldWrap = this.fancybox.option("Image.wrap");

    if (shouldWrap) {
      const $wrap = document.createElement("div");
      $wrap.classList.add(typeof shouldWrap === "string" ? shouldWrap : "fancybox__image-wrap");

      $wrap.appendChild($image);

      $content.appendChild($wrap);

      slide.$wrap = $wrap;
    } else {
      $content.appendChild($image);
    }

    // Set data attribute if other that default
    // for example, set `[data-image-fit="contain-w"]`
    slide.$el.dataset.imageFit = this.fancybox.option("Image.fit");

    // Append content
    this.fancybox.setContent(slide, $content);

    // Display loading icon
    if ($image.complete || $image.error) {
      this.onImageStatusChange(slide);
    } else {
      this.fancybox.showLoading(slide);
    }
  }

  /**
   * Handle image state change, display error or start revealing image
   * @param {Object} slide
   */
  onImageStatusChange(slide) {
    const $image = slide.$image;

    if (!$image || slide.state !== "loading") {
      return;
    }

    if (!($image.complete && $image.naturalWidth && $image.naturalHeight)) {
      this.fancybox.setError(slide, "{{IMAGE_ERROR}}");

      return;
    }

    this.fancybox.hideLoading(slide);

    if (this.fancybox.option("Image.fit") === "contain") {
      this.initSlidePanzoom(slide);
    }

    // Add `wheel` and `click` event handler
    slide.$el.addEventListener("wheel", (event) => this.onWheel(slide, event), { passive: false });
    slide.$content.addEventListener("click", (event) => this.onClick(slide, event), { passive: false });

    this.revealContent(slide);
  }

  /**
   * Make image zoomable and draggable using Panzoom
   * @param {Object} slide
   */
  initSlidePanzoom(slide) {
    if (slide.Panzoom) {
      return;
    }

    //* Initialize Panzoom
    slide.Panzoom = new _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__.Panzoom(
      slide.$el,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, this.fancybox.option("Image.Panzoom", {}), {
        viewport: slide.$wrap,
        content: slide.$image,

        width: slide._width,
        height: slide._height,

        wrapInner: false,

        // Allow to select caption text
        textSelection: true,

        // Toggle gestures
        touch: this.fancybox.option("Image.touch"),

        // This will prevent click conflict with fancybox main carousel
        panOnlyZoomed: true,

        // Disable default click / wheel events as custom event listeners will replace them,
        // because click and wheel events should work without Panzoom
        click: false,
        wheel: false,
      })
    );

    slide.Panzoom.on("startAnimation", () => {
      this.fancybox.trigger("Image.startAnimation", slide);
    });

    slide.Panzoom.on("endAnimation", () => {
      if (slide.state === "zoomIn") {
        this.fancybox.done(slide);
      }

      this.handleCursor(slide);

      this.fancybox.trigger("Image.endAnimation", slide);
    });

    slide.Panzoom.on("afterUpdate", () => {
      this.handleCursor(slide);

      this.fancybox.trigger("Image.afterUpdate", slide);
    });
  }

  /**
   * Start zoom-in animation if possible, or simply reveal content
   * @param {Object} slide
   */
  revealContent(slide) {
    // Animate only on first run
    if (
      this.fancybox.Carousel.prevPage === null &&
      slide.index === this.fancybox.options.startIndex &&
      this.canZoom(slide)
    ) {
      this.zoomIn();
    } else {
      this.fancybox.revealContent(slide);
    }
  }

  /**
   * Get zoom info for selected slide
   * @param {Object} slide
   */
  getZoomInfo(slide) {
    const $thumb = slide.$thumb,
      thumbRect = $thumb.getBoundingClientRect(),
      thumbWidth = thumbRect.width,
      thumbHeight = thumbRect.height,
      //
      contentRect = slide.$content.getBoundingClientRect(),
      contentWidth = contentRect.width,
      contentHeight = contentRect.height,
      //
      shiftedTop = contentRect.top - thumbRect.top,
      shiftedLeft = contentRect.left - thumbRect.left;

    // Check if need to update opacity
    let opacity = this.fancybox.option("Image.zoomOpacity");

    if (opacity === "auto") {
      opacity = Math.abs(thumbWidth / thumbHeight - contentWidth / contentHeight) > 0.1;
    }

    return {
      top: shiftedTop,
      left: shiftedLeft,
      scale: contentWidth && thumbWidth ? thumbWidth / contentWidth : 1,
      opacity: opacity,
    };
  }

  /**
   * Determine if it is possible to do zoom-in animation
   */
  canZoom(slide) {
    const fancybox = this.fancybox,
      $container = fancybox.$container;

    if (window.visualViewport && window.visualViewport.scale !== 1) {
      return false;
    }

    if (slide.Panzoom && !slide.Panzoom.content.width) {
      return false;
    }

    if (!fancybox.option("Image.zoom") || fancybox.option("Image.fit") !== "contain") {
      return false;
    }

    const $thumb = slide.$thumb;

    if (!$thumb || slide.state === "loading") {
      return false;
    }

    // * Check if thumbnail image is really visible
    $container.classList.add("fancybox__no-click");

    const rect = $thumb.getBoundingClientRect();

    let rez;

    // Check if thumbnail image is actually visible on the screen
    if (this.fancybox.option("Image.ignoreCoveredThumbnail")) {
      const visibleTopLeft = document.elementFromPoint(rect.left + 1, rect.top + 1) === $thumb;
      const visibleBottomRight = document.elementFromPoint(rect.right - 1, rect.bottom - 1) === $thumb;

      rez = visibleTopLeft && visibleBottomRight;
    } else {
      rez = document.elementFromPoint(rect.left + rect.width * 0.5, rect.top + rect.height * 0.5) === $thumb;
    }

    $container.classList.remove("fancybox__no-click");

    return rez;
  }

  /**
   * Perform zoom-in animation
   */
  zoomIn() {
    const fancybox = this.fancybox,
      slide = fancybox.getSlide(),
      Panzoom = slide.Panzoom;

    const { top, left, scale, opacity } = this.getZoomInfo(slide);

    fancybox.trigger("reveal", slide);

    // Scale and move to start position
    Panzoom.panTo({
      x: left * -1,
      y: top * -1,
      scale: scale,
      friction: 0,
      ignoreBounds: true,
    });

    slide.$content.style.visibility = "";

    slide.state = "zoomIn";

    if (opacity === true) {
      Panzoom.on("afterTransform", (panzoom) => {
        if (slide.state === "zoomIn" || slide.state === "zoomOut") {
          panzoom.$content.style.opacity = Math.min(1, 1 - (1 - panzoom.content.scale) / (1 - scale));
        }
      });
    }

    // Animate back to original position
    Panzoom.panTo({
      x: 0,
      y: 0,
      scale: 1,
      friction: this.fancybox.option("Image.zoomFriction"),
    });
  }

  /**
   * Perform zoom-out animation
   */
  zoomOut() {
    const fancybox = this.fancybox,
      slide = fancybox.getSlide(),
      Panzoom = slide.Panzoom;

    if (!Panzoom) {
      return;
    }

    slide.state = "zoomOut";
    fancybox.state = "customClosing";

    if (slide.$caption) {
      slide.$caption.style.visibility = "hidden";
    }

    let friction = this.fancybox.option("Image.zoomFriction");

    const animatePosition = (event) => {
      const { top, left, scale, opacity } = this.getZoomInfo(slide);

      // Increase speed on the first run if opacity is not animated
      if (!event && !opacity) {
        friction *= 0.82;
      }

      Panzoom.panTo({
        x: left * -1,
        y: top * -1,
        scale,
        friction,
        ignoreBounds: true,
      });

      // Gradually increase speed
      friction *= 0.98;
    };

    // Page scrolling will cause thumbnail to change position on the display,
    // therefore animation end position has to be recalculated after each page scroll
    window.addEventListener("scroll", animatePosition);

    Panzoom.once("endAnimation", () => {
      window.removeEventListener("scroll", animatePosition);
      fancybox.destroy();
    });

    animatePosition();
  }

  /**
   * Set the type of mouse cursor to indicate if content is zoomable
   * @param {Object} slide
   */
  handleCursor(slide) {
    if (slide.type !== "image" || !slide.$el) {
      return;
    }

    const panzoom = slide.Panzoom;
    const clickAction = this.fancybox.option("Image.click", false, slide);
    const touchIsEnabled = this.fancybox.option("Image.touch");

    const classList = slide.$el.classList;

    const zoomInClass = this.fancybox.option("Image.canZoomInClass");
    const zoomOutClass = this.fancybox.option("Image.canZoomOutClass");

    classList.remove(zoomOutClass);
    classList.remove(zoomInClass);

    if (panzoom && clickAction === "toggleZoom") {
      const canZoomIn =
        panzoom && panzoom.content.scale === 1 && panzoom.option("maxScale") - panzoom.content.scale > 0.01;

      if (canZoomIn) {
        classList.add(zoomInClass);
      } else if (panzoom.content.scale > 1 && !touchIsEnabled) {
        classList.add(zoomOutClass);
      }
    } else if (clickAction === "close") {
      classList.add(zoomOutClass);
    }
  }

  /**
   * Handle `wheel` event
   * @param {Object} slide
   * @param {Object} event
   */
  onWheel(slide, event) {
    if (this.fancybox.state !== "ready") {
      return;
    }

    if (this.fancybox.trigger("Image.wheel", event) === false) {
      return;
    }

    switch (this.fancybox.option("Image.wheel")) {
      case "zoom":
        if (slide.state === "done") {
          slide.Panzoom && slide.Panzoom.zoomWithWheel(event);
        }

        break;

      case "close":
        this.fancybox.close();

        break;

      case "slide":
        this.fancybox[event.deltaY < 0 ? "prev" : "next"]();

        break;
    }
  }

  /**
   * Handle `click` and `dblclick` events
   * @param {Object} slide
   * @param {Object} event
   */
  onClick(slide, event) {
    // Check that clicks should be allowed
    if (this.fancybox.state !== "ready") {
      return;
    }

    const panzoom = slide.Panzoom;

    if (
      panzoom &&
      (panzoom.dragPosition.midPoint ||
        panzoom.dragOffset.x !== 0 ||
        panzoom.dragOffset.y !== 0 ||
        panzoom.dragOffset.scale !== 1)
    ) {
      return;
    }

    if (this.fancybox.Carousel.Panzoom.lockAxis) {
      return false;
    }

    const process = (action) => {
      switch (action) {
        case "toggleZoom":
          event.stopPropagation();

          slide.Panzoom && slide.Panzoom.zoomWithClick(event);

          break;

        case "close":
          this.fancybox.close();

          break;

        case "next":
          event.stopPropagation();

          this.fancybox.next();

          break;
      }
    };

    const clickAction = this.fancybox.option("Image.click");
    const dblclickAction = this.fancybox.option("Image.doubleClick");

    if (dblclickAction) {
      if (this.clickTimer) {
        clearTimeout(this.clickTimer);
        this.clickTimer = null;

        process(dblclickAction);
      } else {
        this.clickTimer = setTimeout(() => {
          this.clickTimer = null;
          process(clickAction);
        }, 300);
      }
    } else {
      process(clickAction);
    }
  }

  /**
   * Handle `Carousel.change` event to reset zoom level for any zoomed in/out content
   * and to revel content of the current page
   * @param {Object} fancybox
   * @param {Object} carousel
   */
  onPageChange(fancybox, carousel) {
    const currSlide = fancybox.getSlide();

    carousel.slides.forEach((slide) => {
      if (!slide.Panzoom || slide.state !== "done") {
        return;
      }

      if (slide.index !== currSlide.index) {
        slide.Panzoom.panTo({
          x: 0,
          y: 0,
          scale: 1,
          friction: 0.8,
        });
      }
    });
  }

  attach() {
    this.fancybox.on(this.events);
  }

  detach() {
    this.fancybox.off(this.events);
  }
}

// Expose defaults
Image.defaults = defaults;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/ScrollLock/ScrollLock.js":
/*!***********************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/plugins/ScrollLock/ScrollLock.js ***!
  \***********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ScrollLock": function() { return /* binding */ ScrollLock; }
/* harmony export */ });
/* harmony import */ var _src_shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../src/shared/utils/isScrollable.js */ "../node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js");


class ScrollLock {
  constructor(fancybox) {
    this.fancybox = fancybox;
    this.viewport = null;

    this.pendingUpdate = null;

    for (const methodName of ["onReady", "onResize", "onTouchstart", "onTouchmove"]) {
      this[methodName] = this[methodName].bind(this);
    }
  }

  /**
   * Process `initLayout` event to attach event listeners and resize viewport if needed
   */
  onReady() {
    //* Support Visual Viewport API
    // https://developer.mozilla.org/en-US/docs/Web/API/Visual_Viewport_API
    const viewport = window.visualViewport;

    if (viewport) {
      this.viewport = viewport;
      this.startY = 0;

      viewport.addEventListener("resize", this.onResize);

      this.updateViewport();
    }

    //* Prevent bouncing while scrolling on mobile devices
    window.addEventListener("touchstart", this.onTouchstart, { passive: false });
    window.addEventListener("touchmove", this.onTouchmove, { passive: false });

    //* Prevent window scrolling with mouse wheel
    window.addEventListener("wheel", this.onWheel, { passive: false });
  }

  /**
   * Handle `resize` event to call `updateViewport`
   */
  onResize() {
    this.updateViewport();
  }

  /**
   * Scale $container proportionally to actually fit inside browser,
   * e.g., disable viewport zooming
   */
  updateViewport() {
    const fancybox = this.fancybox,
      viewport = this.viewport,
      scale = viewport.scale || 1,
      $container = fancybox.$container;

    if (!$container) {
      return;
    }

    let width = "",
      height = "",
      transform = "";

    if (scale - 1 > 0.1) {
      width = `${viewport.width * scale}px`;
      height = `${viewport.height * scale}px`;
      transform = `translate3d(${viewport.offsetLeft}px, ${viewport.offsetTop}px, 0) scale(${1 / scale})`;
    }

    $container.style.width = width;
    $container.style.height = height;
    $container.style.transform = transform;
  }

  /**
   * Handle `touchstart` event to mark drag start position
   * @param {Object} event
   */
  onTouchstart(event) {
    this.startY = event.touches ? event.touches[0].screenY : event.screenY;
  }

  /**
   * Handle `touchmove` event to fix scrolling on mobile devices (iOS)
   * @param {Object} event
   */
  onTouchmove(event) {
    const startY = this.startY;
    const zoom = window.innerWidth / window.document.documentElement.clientWidth;

    if (!event.cancelable) {
      return;
    }

    if (event.touches.length > 1 || zoom !== 1) {
      return;
    }

    const el = (0,_src_shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_0__.isScrollable)(event.composedPath()[0]);

    if (!el) {
      event.preventDefault();
      return;
    }

    const style = window.getComputedStyle(el);
    const height = parseInt(style.getPropertyValue("height"), 10);

    const curY = event.touches ? event.touches[0].screenY : event.screenY;

    const isAtTop = startY <= curY && el.scrollTop === 0;
    const isAtBottom = startY >= curY && el.scrollHeight - el.scrollTop === height;

    if (isAtTop || isAtBottom) {
      event.preventDefault();
    }
  }

  /**
   * Handle `wheel` event
   */
  onWheel(event) {
    if (!(0,_src_shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_0__.isScrollable)(event.composedPath()[0])) {
      event.preventDefault();
    }
  }

  /**
   * Clean everything up
   */
  cleanup() {
    if (this.pendingUpdate) {
      cancelAnimationFrame(this.pendingUpdate);
      this.pendingUpdate = null;
    }

    const viewport = this.viewport;

    if (viewport) {
      viewport.removeEventListener("resize", this.onResize);
      this.viewport = null;
    }

    window.removeEventListener("touchstart", this.onTouchstart, false);
    window.removeEventListener("touchmove", this.onTouchmove, false);

    window.removeEventListener("wheel", this.onWheel, { passive: false });
  }

  attach() {
    this.fancybox.on("initLayout", this.onReady);
  }

  detach() {
    this.fancybox.off("initLayout", this.onReady);

    this.cleanup();
  }
}


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Thumbs/Thumbs.js":
/*!***************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/plugins/Thumbs/Thumbs.js ***!
  \***************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Thumbs": function() { return /* binding */ Thumbs; }
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../Carousel/Carousel.js */ "../node_modules/@fancyapps/ui/src/Carousel/Carousel.js");



const defaults = {
  // The minimum number of images in the gallery to display thumbnails
  minSlideCount: 2,

  // Minimum screen height to display thumbnails
  minScreenHeight: 500,

  // Automatically show thumbnails when opened
  autoStart: true,

  // Keyboard shortcut to toggle thumbnail container
  key: "t",

  // Customize Carousel instance
  Carousel: {},
};

class Thumbs {
  constructor(fancybox) {
    this.fancybox = fancybox;

    this.$container = null;
    this.state = "init";

    for (const methodName of ["onPrepare", "onClosing", "onKeydown"]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      prepare: this.onPrepare,
      closing: this.onClosing,
      keydown: this.onKeydown,
    };
  }

  /**
   * Process `prepare` event to build the layout
   */
  onPrepare() {
    // Get slides, skip if the total number is less than the minimum
    const slides = this.getSlides();

    if (slides.length < this.fancybox.option("Thumbs.minSlideCount")) {
      this.state = "disabled";
      return;
    }

    if (
      this.fancybox.option("Thumbs.autoStart") === true &&
      this.fancybox.Carousel.Panzoom.content.height >= this.fancybox.option("Thumbs.minScreenHeight")
    ) {
      this.build();
    }
  }

  /**
   * Process `closing` event to disable all events
   */
  onClosing() {
    if (this.Carousel) {
      this.Carousel.Panzoom.detachEvents();
    }
  }

  /**
   * Process `keydown` event to enable thumbnail list toggling using keyboard key
   * @param {Object} fancybox
   * @param {String} key
   */
  onKeydown(fancybox, key) {
    if (key === fancybox.option("Thumbs.key")) {
      this.toggle();
    }
  }

  /**
   * Build layout and init thumbnail Carousel
   */
  build() {
    if (this.$container) {
      return;
    }

    // Create wrapping element and append to layout
    const $container = document.createElement("div");

    $container.classList.add("fancybox__thumbs");

    this.fancybox.$carousel.parentNode.insertBefore($container, this.fancybox.$carousel.nextSibling);

    // Initialise thumbnail carousel with all slides
    this.Carousel = new _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_1__.Carousel(
      $container,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(
        true,
        {
          Dots: false,
          Navigation: false,
          Sync: {
            friction: 0,
          },
          infinite: false,
          center: true,
          fill: true,
          dragFree: true,
          slidesPerPage: 1,
          preload: 1,
        },
        this.fancybox.option("Thumbs.Carousel"),
        {
          Sync: {
            target: this.fancybox.Carousel,
          },
          slides: this.getSlides(),
        }
      )
    );

    // Slide carousel on wheel event
    this.Carousel.Panzoom.on("wheel", (panzoom, event) => {
      event.preventDefault();

      this.fancybox[event.deltaY < 0 ? "prev" : "next"]();
    });

    this.$container = $container;

    this.state = "visible";
  }

  /**
   * Process all fancybox slides to get all thumbnail images
   */
  getSlides() {
    const slides = [];

    for (const slide of this.fancybox.items) {
      const thumb = slide.thumb;

      if (thumb) {
        slides.push({
          html: `<div class="fancybox__thumb" style="background-image:url('${thumb}')"></div>`,
          customClass: `has-thumb has-${slide.type || "image"}`,
        });
      }
    }

    return slides;
  }

  /**
   * Toggle visibility of thumbnail list
   * Tip: you can use `Fancybox.getInstance().plugins.Thumbs.toggle()` from anywhere in your code
   */
  toggle() {
    if (this.state === "visible") {
      this.hide();
    } else if (this.state === "hidden") {
      this.show();
    } else {
      this.build();
    }
  }

  /**
   * Show thumbnail list
   */
  show() {
    if (this.state === "hidden") {
      this.$container.style.display = "";

      this.Carousel.Panzoom.attachEvents();

      this.state = "visible";
    }
  }

  /**
   * Hide thumbnail list
   */
  hide() {
    if (this.state === "visible") {
      this.Carousel.Panzoom.detachEvents();

      this.$container.style.display = "none";

      this.state = "hidden";
    }
  }

  /**
   * Reset the state
   */
  cleanup() {
    if (this.Carousel) {
      this.Carousel.destroy();
      this.Carousel = null;
    }

    if (this.$container) {
      this.$container.remove();
      this.$container = null;
    }

    this.state = "init";
  }

  attach() {
    this.fancybox.on(this.events);
  }

  detach() {
    this.fancybox.off(this.events);

    this.cleanup();
  }
}

// Expose defaults
Thumbs.defaults = defaults;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Toolbar/Toolbar.js":
/*!*****************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/plugins/Toolbar/Toolbar.js ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Toolbar": function() { return /* binding */ Toolbar; }
/* harmony export */ });
/* harmony import */ var _shared_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/isPlainObject.js */ "../node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js");
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../shared/utils/Fullscreen.js */ "../node_modules/@fancyapps/ui/src/shared/utils/Fullscreen.js");
/* harmony import */ var _shared_utils_Slideshow_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../shared/utils/Slideshow.js */ "../node_modules/@fancyapps/ui/src/shared/utils/Slideshow.js");






const defaults = {
  // What toolbar items to display
  display: [
    "counter",
    //"prev",
    //"next",
    //"download",
    "zoom",
    "slideshow",
    "fullscreen",
    "thumbs",
    "close",
  ],

  // Only create a toolbar item if there is at least one image in the group
  autoEnable: true,

  // Toolbar items; can be links, buttons or `div` elements
  items: {
    counter: {
      position: "left",
      type: "div",
      class: "fancybox__counter",
      html: '<span data-fancybox-index=""></span>&nbsp;/&nbsp;<span data-fancybox-count=""></span>',
      attr: { tabindex: -1 },
    },
    prev: {
      type: "button",
      class: "fancybox__button--prev",
      label: "PREV",
      html: '<svg viewBox="0 0 24 24"><path d="M15 4l-8 8 8 8"/></svg>',
      attr: { "data-fancybox-prev": "" },
    },
    next: {
      type: "button",
      class: "fancybox__button--next",
      label: "NEXT",
      html: '<svg viewBox="0 0 24 24"><path d="M8 4l8 8-8 8"/></svg>',
      attr: { "data-fancybox-next": "" },
    },
    fullscreen: {
      type: "button",
      class: "fancybox__button--fullscreen",
      label: "TOGGLE_FULLSCREEN",
      html: `<svg viewBox="0 0 24 24">
                <g><path d="M3 8 V3h5"></path><path d="M21 8V3h-5"></path><path d="M8 21H3v-5"></path><path d="M16 21h5v-5"></path></g>
                <g><path d="M7 2v5H2M17 2v5h5M2 17h5v5M22 17h-5v5"/></g>
            </svg>`,
      click: function (event) {
        event.preventDefault();

        if (_shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.element()) {
          _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.deactivate();
        } else {
          _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.activate(this.fancybox.$container);
        }
      },
    },
    slideshow: {
      type: "button",
      class: "fancybox__button--slideshow",
      label: "TOGGLE_SLIDESHOW",
      html: `<svg viewBox="0 0 24 24">
                <g><path d="M6 4v16"/><path d="M20 12L6 20"/><path d="M20 12L6 4"/></g>
                <g><path d="M7 4v15M17 4v15"/></g>
            </svg>`,
      click: function (event) {
        event.preventDefault();

        this.Slideshow.toggle();
      },
    },
    zoom: {
      type: "button",
      class: "fancybox__button--zoom",
      label: "TOGGLE_ZOOM",
      html: '<svg viewBox="0 0 24 24"><circle cx="10" cy="10" r="7"></circle><path d="M16 16 L21 21"></svg>',
      click: function (event) {
        event.preventDefault();

        const panzoom = this.fancybox.getSlide().Panzoom;

        if (panzoom) {
          panzoom.toggleZoom();
        }
      },
    },
    download: {
      type: "link",
      label: "DOWNLOAD",
      class: "fancybox__button--download",
      html: '<svg viewBox="0 0 24 24"><path d="M12 15V3m0 12l-4-4m4 4l4-4M2 17l.62 2.48A2 2 0 004.56 21h14.88a2 2 0 001.94-1.51L22 17"/></svg>',
      click: function (event) {
        event.stopPropagation();
      },
    },
    thumbs: {
      type: "button",
      label: "TOGGLE_THUMBS",
      class: "fancybox__button--thumbs",
      html: '<svg viewBox="0 0 24 24"><circle cx="4" cy="4" r="1" /><circle cx="12" cy="4" r="1" transform="rotate(90 12 4)"/><circle cx="20" cy="4" r="1" transform="rotate(90 20 4)"/><circle cx="4" cy="12" r="1" transform="rotate(90 4 12)"/><circle cx="12" cy="12" r="1" transform="rotate(90 12 12)"/><circle cx="20" cy="12" r="1" transform="rotate(90 20 12)"/><circle cx="4" cy="20" r="1" transform="rotate(90 4 20)"/><circle cx="12" cy="20" r="1" transform="rotate(90 12 20)"/><circle cx="20" cy="20" r="1" transform="rotate(90 20 20)"/></svg>',
      click: function (event) {
        event.stopPropagation();

        const thumbs = this.fancybox.plugins.Thumbs;

        if (thumbs) {
          thumbs.toggle();
        }
      },
    },
    close: {
      type: "button",
      label: "CLOSE",
      class: "fancybox__button--close",
      html: '<svg viewBox="0 0 24 24"><path d="M20 20L4 4m16 0L4 20"></path></svg>',
      attr: { "data-fancybox-close": "", tabindex: 0 },
    },
  },
};

class Toolbar {
  constructor(fancybox) {
    this.fancybox = fancybox;

    this.$container = null;
    this.state = "init";

    for (const methodName of [
      "onInit",
      "onPrepare",
      "onDone",
      "onKeydown",
      "onClosing",
      "onChange",
      "onSettle",
      "onRefresh",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      init: this.onInit,
      prepare: this.onPrepare,
      done: this.onDone,
      keydown: this.onKeydown,
      closing: this.onClosing,

      // Clear Slideshow when user strts to change current slide
      "Carousel.change": this.onChange,

      // Set timer after carousel changes current slide; deactive if last slide is reached
      "Carousel.settle": this.onSettle,

      // Deactivate Slideshow on user interaction
      "Carousel.Panzoom.touchStart": () => this.onRefresh(),

      "Image.startAnimation": (fancybox, slide) => this.onRefresh(slide),
      "Image.afterUpdate": (fancybox, slide) => this.onRefresh(slide),
    };
  }

  onInit() {
    // Disable self if current group does not contain at least one image
    if (this.fancybox.option("Toolbar.autoEnable")) {
      let hasImage = false;

      for (const item of this.fancybox.items) {
        if (item.type === "image") {
          hasImage = true;
          break;
        }
      }

      if (!hasImage) {
        this.state = "disabled";
        return;
      }
    }

    // Disable the creation of a close button, if one exists in the toolbar
    for (const key of this.fancybox.option("Toolbar.display")) {
      const id = (0,_shared_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__.isPlainObject)(key) ? key.id : key;

      if (id === "close") {
        this.fancybox.options.closeButton = false;

        break;
      }
    }
  }

  onPrepare() {
    const fancybox = this.fancybox;
    // Skip if disabled
    if (this.state !== "init") {
      return;
    }

    this.build();

    this.update();

    this.Slideshow = new _shared_utils_Slideshow_js__WEBPACK_IMPORTED_MODULE_3__.Slideshow(fancybox);

    if (!fancybox.Carousel.prevPage) {
      if (fancybox.option("slideshow.autoStart")) {
        this.Slideshow.activate();
      }

      if (fancybox.option("fullscreen.autoStart") && !_shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.element()) {
        try {
          _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.activate(fancybox.$container);
        } catch (error) {}
      }
    }
  }

  onFsChange() {
    window.scrollTo(_shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.pageXOffset, _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.pageYOffset);
  }

  onSettle() {
    const fancybox = this.fancybox;
    const slideshow = this.Slideshow;

    if (slideshow && slideshow.isActive()) {
      if (fancybox.getSlide().index === fancybox.Carousel.slides.length - 1 && !fancybox.option("infinite")) {
        slideshow.deactivate();
      } else if (fancybox.getSlide().state === "done") {
        slideshow.setTimer();
      }
    }
  }

  onChange() {
    this.update();

    if (this.Slideshow && this.Slideshow.isActive()) {
      this.Slideshow.clearTimer();
    }
  }

  onDone(fancybox, slide) {
    const slideshow = this.Slideshow;

    if (slide.index === fancybox.getSlide().index) {
      this.update();

      if (slideshow && slideshow.isActive()) {
        if (!fancybox.option("infinite") && slide.index === fancybox.Carousel.slides.length - 1) {
          slideshow.deactivate();
        } else {
          slideshow.setTimer();
        }
      }
    }
  }

  onRefresh(slide) {
    if (!slide || slide.index === this.fancybox.getSlide().index) {
      this.update();

      if (this.Slideshow && this.Slideshow.isActive() && (!slide || slide.state === "done")) {
        this.Slideshow.deactivate();
      }
    }
  }

  onKeydown(fancybox, key, event) {
    if (key === " " && this.Slideshow) {
      this.Slideshow.toggle();

      event.preventDefault();
    }
  }

  onClosing() {
    if (this.Slideshow) {
      this.Slideshow.deactivate();
    }

    document.removeEventListener("fullscreenchange", this.onFsChange);
  }

  /**
   * Create link, button or `div` element for the toolbar
   * @param {Object} obj
   * @returns HTMLElement
   */
  createElement(obj) {
    let $el;

    if (obj.type === "div") {
      $el = document.createElement("div");
    } else {
      $el = document.createElement(obj.type === "link" ? "a" : "button");
      $el.classList.add("carousel__button");
    }

    $el.innerHTML = obj.html;

    $el.setAttribute("tabindex", obj.tabindex || 0);

    if (obj.class) {
      $el.classList.add(...obj.class.split(" "));
    }

    for (const prop in obj.attr) {
      $el.setAttribute(prop, obj.attr[prop]);
    }

    if (obj.label) {
      $el.setAttribute("title", this.fancybox.localize(`{{${obj.label}}}`));
    }

    if (obj.click) {
      $el.addEventListener("click", obj.click.bind(this));
    }

    if (obj.id === "prev") {
      $el.setAttribute("data-fancybox-prev", "");
    }

    if (obj.id === "next") {
      $el.setAttribute("data-fancybox-next", "");
    }

    const $svg = $el.querySelector("svg");

    if ($svg) {
      $svg.setAttribute("role", "img");
      $svg.setAttribute("tabindex", "-1");
      $svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    }

    return $el;
  }

  /**
   * Create all DOM elements
   */
  build() {
    this.cleanup();

    const all_items = this.fancybox.option("Toolbar.items");
    const all_groups = [
      {
        position: "left",
        items: [],
      },
      {
        position: "center",
        items: [],
      },
      {
        position: "right",
        items: [],
      },
    ];

    const thumbs = this.fancybox.plugins.Thumbs;

    // 1st step - group toolbar elements by position
    for (const key of this.fancybox.option("Toolbar.display")) {
      let id, item;

      if ((0,_shared_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__.isPlainObject)(key)) {
        id = key.id;
        item = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_1__.extend)({}, all_items[id], key);
      } else {
        id = key;
        item = all_items[id];
      }

      if (["counter", "next", "prev", "slideshow"].includes(id) && this.fancybox.items.length < 2) {
        continue;
      }

      if (id === "fullscreen") {
        if (!document.fullscreenEnabled || window.fullScreen) {
          continue;
        }

        document.addEventListener("fullscreenchange", this.onFsChange);
      }

      if (id === "thumbs" && (!thumbs || thumbs.state === "disabled")) {
        continue;
      }

      if (!item) {
        continue;
      }

      let position = item.position || "right";

      let group = all_groups.find((obj) => obj.position === position);

      if (group) {
        group.items.push(item);
      }
    }

    // 2st step - create DOM elements
    const $container = document.createElement("div");
    $container.classList.add("fancybox__toolbar");

    for (const group of all_groups) {
      if (group.items.length) {
        const $wrap = document.createElement("div");
        $wrap.classList.add("fancybox__toolbar__items");
        $wrap.classList.add(`fancybox__toolbar__items--${group.position}`);

        for (const obj of group.items) {
          $wrap.appendChild(this.createElement(obj));
        }

        $container.appendChild($wrap);
      }
    }

    // Add toolbar container to DOM
    this.fancybox.$carousel.parentNode.insertBefore($container, this.fancybox.$carousel);

    this.$container = $container;
  }

  /**
   * Update element state depending on index of current slide
   */
  update() {
    const slide = this.fancybox.getSlide();
    const idx = slide.index;
    const cnt = this.fancybox.items.length;

    // Download links
    // ====
    const src = slide.downloadSrc || (slide.type === "image" && !slide.error ? slide.src : null);

    for (const $el of this.fancybox.$container.querySelectorAll("a.fancybox__button--download")) {
      if (src) {
        $el.removeAttribute("disabled");
        $el.removeAttribute("tabindex");

        $el.setAttribute("href", src);
        $el.setAttribute("download", src);
        $el.setAttribute("target", "_blank");
      } else {
        $el.setAttribute("disabled", "");
        $el.setAttribute("tabindex", -1);

        $el.removeAttribute("href");
        $el.removeAttribute("download");
      }
    }

    // Zoom button
    // ===
    const panzoom = slide.Panzoom;
    const canZoom = panzoom && panzoom.option("maxScale") > panzoom.option("baseScale");

    for (const $el of this.fancybox.$container.querySelectorAll(".fancybox__button--zoom")) {
      if (canZoom) {
        $el.removeAttribute("disabled");
      } else {
        $el.setAttribute("disabled", "");
      }
    }

    // Counter
    // ====
    for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-index]")) {
      $el.innerHTML = slide.index + 1;
    }

    for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-count]")) {
      $el.innerHTML = cnt;
    }

    // Disable previous/next links if gallery is not infinite and has reached start/end
    // ===
    if (!this.fancybox.option("infinite")) {
      for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-prev]")) {
        if (idx === 0) {
          $el.setAttribute("disabled", "");
        } else {
          $el.removeAttribute("disabled");
        }
      }

      for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-next]")) {
        if (idx === cnt - 1) {
          $el.setAttribute("disabled", "");
        } else {
          $el.removeAttribute("disabled");
        }
      }
    }
  }

  cleanup() {
    if (this.Slideshow && this.Slideshow.isActive()) {
      this.Slideshow.clearTimer();
    }

    if (this.$container) {
      this.$container.remove();
    }

    this.$container = null;
  }

  attach() {
    this.fancybox.on(this.events);
  }

  detach() {
    this.fancybox.off(this.events);

    this.cleanup();
  }
}

// Expose defaults
Toolbar.defaults = defaults;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/index.js":
/*!*******************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Fancybox/plugins/index.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Plugins": function() { return /* binding */ Plugins; }
/* harmony export */ });
/* harmony import */ var _ScrollLock_ScrollLock_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ScrollLock/ScrollLock.js */ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/ScrollLock/ScrollLock.js");
/* harmony import */ var _Thumbs_Thumbs_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Thumbs/Thumbs.js */ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Thumbs/Thumbs.js");
/* harmony import */ var _Html_Html_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Html/Html.js */ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Html/Html.js");
/* harmony import */ var _Image_Image_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Image/Image.js */ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Image/Image.js");
/* harmony import */ var _Hash_Hash_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Hash/Hash.js */ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Hash/Hash.js");
/* harmony import */ var _Toolbar_Toolbar_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./Toolbar/Toolbar.js */ "../node_modules/@fancyapps/ui/src/Fancybox/plugins/Toolbar/Toolbar.js");







const Plugins = {
  ScrollLock: _ScrollLock_ScrollLock_js__WEBPACK_IMPORTED_MODULE_0__.ScrollLock,
  Thumbs: _Thumbs_Thumbs_js__WEBPACK_IMPORTED_MODULE_1__.Thumbs,
  Html: _Html_Html_js__WEBPACK_IMPORTED_MODULE_2__.Html,
  Toolbar: _Toolbar_Toolbar_js__WEBPACK_IMPORTED_MODULE_5__.Toolbar,
  Image: _Image_Image_js__WEBPACK_IMPORTED_MODULE_3__.Image,
  Hash: _Hash_Hash_js__WEBPACK_IMPORTED_MODULE_4__.Hash,
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js":
/*!************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Panzoom": function() { return /* binding */ Panzoom; }
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../shared/utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../shared/utils/round.js */ "../node_modules/@fancyapps/ui/src/shared/utils/round.js");
/* harmony import */ var _shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../shared/utils/isScrollable.js */ "../node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js");
/* harmony import */ var _shared_utils_ResizeObserver_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../shared/utils/ResizeObserver.js */ "../node_modules/@fancyapps/ui/src/shared/utils/ResizeObserver.js");
/* harmony import */ var _shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../shared/utils/PointerTracker.js */ "../node_modules/@fancyapps/ui/src/shared/utils/PointerTracker.js");
/* harmony import */ var _shared_utils_getTextNodeFromPoint_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../shared/utils/getTextNodeFromPoint.js */ "../node_modules/@fancyapps/ui/src/shared/utils/getTextNodeFromPoint.js");
/* harmony import */ var _shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../shared/utils/getDimensions.js */ "../node_modules/@fancyapps/ui/src/shared/utils/getDimensions.js");
/* harmony import */ var _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../shared/Base/Base.js */ "../node_modules/@fancyapps/ui/src/shared/Base/Base.js");
/* harmony import */ var _plugins_index_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./plugins/index.js */ "../node_modules/@fancyapps/ui/src/Panzoom/plugins/index.js");















const defaults = {
  // Enable touch guestures
  touch: true,

  // Enable zooming
  zoom: true,

  // Enable pinch gesture to zoom in/out using two fingers
  pinchToZoom: true,

  // Disable dragging if scale level is equal to value of `baseScale` option
  panOnlyZoomed: false,

  // Lock axis while dragging,
  // possible values: false | "x" | "y" | "xy"
  lockAxis: false,

  // * All friction values are inside [0, 1) interval,
  // * where 0 would change instantly, but 0.99 would update extremely slowly

  // Friction while panning/dragging
  friction: 0.64,

  // Friction while decelerating after drag end
  decelFriction: 0.88,

  // Friction while scaling
  zoomFriction: 0.74,

  // Bounciness after hitting the edge
  bounceForce: 0.2,

  // Initial scale level
  baseScale: 1,

  // Minimum scale level
  minScale: 1,

  // Maximum scale level
  maxScale: 2,

  // Default scale step while zooming
  step: 0.5,

  // Allow to select text,
  // if enabled, dragging will be disabled when text selection is detected
  textSelection: false,

  // Add `click` event listener,
  // possible values: true | false | function | "toggleZoom"
  click: "toggleZoom",

  // Add `wheel` event listener,
  // possible values: true | false | function |  "zoom"
  wheel: "zoom",

  // Value for zoom on mouse wheel
  wheelFactor: 42,

  // Number of wheel events after which it should stop preventing default behaviour of mouse wheel
  wheelLimit: 5,

  // Class name added to `$viewport` element to indicate if content is draggable
  draggableClass: "is-draggable",

  // Class name added to `$viewport` element to indicate that user is currently dragging
  draggingClass: "is-dragging",

  // Content will be scaled by this number,
  // this can also be a function which should return a number, for example:
  // ratio: function() { return 1 / (window.devicePixelRatio || 1) }
  ratio: 1,
};

class Panzoom extends _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_7__.Base {
  /**
   * Panzoom constructor
   * @constructs Panzoom
   * @param {HTMLElement} $viewport Panzoom container
   * @param {Object} [options] Options for Panzoom
   */
  constructor($container, options = {}) {
    super((0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, {}, defaults, options));

    this.state = "init";

    this.$container = $container;

    // Bind event handlers for referencability
    for (const methodName of ["onLoad", "onWheel", "onClick"]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.initLayout();

    this.resetValues();

    this.attachPlugins(Panzoom.Plugins);

    this.trigger("init");

    this.updateMetrics();

    this.attachEvents();

    this.trigger("ready");

    if (this.option("centerOnStart") === false) {
      this.state = "ready";
    } else {
      this.panTo({
        friction: 0,
      });
    }

    $container.__Panzoom = this;
  }

  /**
   * Create references to container, viewport and content elements
   */
  initLayout() {
    const $container = this.$container;

    // Make sure content element exists
    if (!($container instanceof HTMLElement)) {
      throw new Error("Panzoom: Container not found");
    }

    const $content = this.option("content") || $container.querySelector(".panzoom__content");

    // Make sure content element exists
    if (!$content) {
      throw new Error("Panzoom: Content not found");
    }

    this.$content = $content;

    let $viewport = this.option("viewport") || $container.querySelector(".panzoom__viewport");

    if (!$viewport && this.option("wrapInner") !== false) {
      $viewport = document.createElement("div");
      $viewport.classList.add("panzoom__viewport");

      $viewport.append(...$container.childNodes);

      $container.appendChild($viewport);
    }

    this.$viewport = $viewport || $content.parentNode;
  }

  /**
   * Restore instance variables to default values
   */
  resetValues() {
    this.updateRate = this.option("updateRate", /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? 250 : 24);

    this.container = {
      width: 0,
      height: 0,
    };

    this.viewport = {
      width: 0,
      height: 0,
    };

    this.content = {
      // Full content dimensions (naturalWidth/naturalHeight for images)
      origWidth: 0,
      origHeight: 0,

      // Current dimensions of the content
      width: 0,
      height: 0,

      // Current position; these values reflect CSS `transform` value
      x: this.option("x", 0),
      y: this.option("y", 0),

      // Current scale; does not reflect CSS `transform` value
      scale: this.option("baseScale"),
    };

    // End values of current pan / zoom animation
    this.transform = {
      x: 0,
      y: 0,
      scale: 1,
    };

    this.resetDragPosition();
  }

  /**
   * Handle `load` event
   * @param {Event} event
   */
  onLoad(event) {
    this.updateMetrics();

    this.panTo({ scale: this.option("baseScale"), friction: 0 });

    this.trigger("load", event);
  }

  /**
   * Handle `click` event
   * @param {Event} event
   */
  onClick(event) {
    if (event.defaultPrevented) {
      return;
    }

    // Skip if text is selected
    if (this.option("textSelection") && window.getSelection().toString().length) {
      event.stopPropagation();
      return;
    }

    const rect = this.$content.getClientRects()[0];

    // Check if container has changed position (for example, when current instance is inside another one)
    if (this.state !== "ready") {
      if (
        this.dragPosition.midPoint ||
        Math.abs(rect.top - this.dragStart.rect.top) > 1 ||
        Math.abs(rect.left - this.dragStart.rect.left) > 1
      ) {
        event.preventDefault();
        event.stopPropagation();

        return;
      }
    }

    if (this.trigger("click", event) === false) {
      return;
    }

    if (this.option("zoom") && this.option("click") === "toggleZoom") {
      event.preventDefault();
      event.stopPropagation();

      this.zoomWithClick(event);
    }
  }

  /**
   * Handle `wheel` event
   * @param {Event} event
   */
  onWheel(event) {
    if (this.trigger("wheel", event) === false) {
      return;
    }

    if (this.option("zoom") && this.option("wheel")) {
      this.zoomWithWheel(event);
    }
  }

  /**
   * Change zoom level depending on scroll direction
   * @param {Event} event `wheel` event
   */
  zoomWithWheel(event) {
    if (this.changedDelta === undefined) {
      this.changedDelta = 0;
    }

    const delta = Math.max(-1, Math.min(1, -event.deltaY || -event.deltaX || event.wheelDelta || -event.detail));
    const scale = this.content.scale;

    let newScale = (scale * (100 + delta * this.option("wheelFactor"))) / 100;

    if (
      (delta < 0 && Math.abs(scale - this.option("minScale")) < 0.01) ||
      (delta > 0 && Math.abs(scale - this.option("maxScale")) < 0.01)
    ) {
      this.changedDelta += Math.abs(delta);
      newScale = scale;
    } else {
      this.changedDelta = 0;
      newScale = Math.max(Math.min(newScale, this.option("maxScale")), this.option("minScale"));
    }

    if (this.changedDelta > this.option("wheelLimit")) {
      return;
    }

    event.preventDefault();

    if (newScale === scale) {
      return;
    }

    const rect = this.$content.getBoundingClientRect();

    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    this.zoomTo(newScale, { x, y });
  }

  /**
   * Change zoom level depending on click coordinates
   * @param {Event} event `click` event
   */
  zoomWithClick(event) {
    const rect = this.$content.getClientRects()[0];

    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    this.toggleZoom({ x, y });
  }

  /**
   * Attach load, wheel and click event listeners, initialize `resizeObserver` and `PointerTracker`
   */
  attachEvents() {
    this.$content.addEventListener("load", this.onLoad);

    this.$container.addEventListener("wheel", this.onWheel, { passive: false });
    this.$container.addEventListener("click", this.onClick, { passive: false });

    this.initObserver();

    const pointerTracker = new _shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_4__.PointerTracker(this.$container, {
      start: (pointer, event) => {
        if (!this.option("touch")) {
          return false;
        }

        if (this.velocity.scale < 0) {
          return false;
        }

        const target = event.composedPath()[0];

        if (!pointerTracker.currentPointers.length) {
          const ignoreClickedElement =
            ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(target.nodeName) !== -1;

          if (ignoreClickedElement) {
            return false;
          }

          // Allow text selection
          if (this.option("textSelection") && (0,_shared_utils_getTextNodeFromPoint_js__WEBPACK_IMPORTED_MODULE_5__.getTextNodeFromPoint)(target, pointer.clientX, pointer.clientY)) {
            return false;
          }
        }

        if ((0,_shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_2__.isScrollable)(target)) {
          return false;
        }

        if (this.trigger("touchStart", event) === false) {
          return false;
        }

        if (event.type === "mousedown") {
          event.preventDefault();
        }

        this.state = "pointerdown";

        this.resetDragPosition();

        this.dragPosition.midPoint = null;
        this.dragPosition.time = Date.now();

        return true;
      },
      move: (previousPointers, currentPointers, event) => {
        if (this.state !== "pointerdown") {
          return;
        }

        if (this.trigger("touchMove", event) === false) {
          event.preventDefault();
          return;
        }

        // Disable touch action if current zoom level is below base level
        if (
          currentPointers.length < 2 &&
          this.option("panOnlyZoomed") === true &&
          this.content.width <= this.viewport.width &&
          this.content.height <= this.viewport.height &&
          this.transform.scale <= this.option("baseScale")
        ) {
          return;
        }

        if (currentPointers.length > 1 && (!this.option("zoom") || this.option("pinchToZoom") === false)) {
          return;
        }

        const prevMidpoint = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_4__.getMidpoint)(previousPointers[0], previousPointers[1]);
        const newMidpoint = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_4__.getMidpoint)(currentPointers[0], currentPointers[1]);

        const panX = newMidpoint.clientX - prevMidpoint.clientX;
        const panY = newMidpoint.clientY - prevMidpoint.clientY;

        const prevDistance = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_4__.getDistance)(previousPointers[0], previousPointers[1]);
        const newDistance = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_4__.getDistance)(currentPointers[0], currentPointers[1]);

        const scaleDiff = prevDistance && newDistance ? newDistance / prevDistance : 1;

        this.dragOffset.x += panX;
        this.dragOffset.y += panY;

        this.dragOffset.scale *= scaleDiff;

        this.dragOffset.time = Date.now() - this.dragPosition.time;

        const axisToLock = this.dragStart.scale === 1 && this.option("lockAxis");

        if (axisToLock && !this.lockAxis) {
          if (Math.abs(this.dragOffset.x) < 6 && Math.abs(this.dragOffset.y) < 6) {
            event.preventDefault();
            return;
          }

          const angle = Math.abs((Math.atan2(this.dragOffset.y, this.dragOffset.x) * 180) / Math.PI);

          this.lockAxis = angle > 45 && angle < 135 ? "y" : "x";
        }

        if (axisToLock !== "xy" && this.lockAxis === "y") {
          return;
        }

        event.preventDefault();
        event.stopPropagation();

        event.stopImmediatePropagation();

        if (this.lockAxis) {
          this.dragOffset[this.lockAxis === "x" ? "y" : "x"] = 0;
        }

        this.$container.classList.add(this.option("draggingClass"));

        if (!(this.transform.scale === this.option("baseScale") && this.lockAxis === "y")) {
          this.dragPosition.x = this.dragStart.x + this.dragOffset.x;
        }

        if (!(this.transform.scale === this.option("baseScale") && this.lockAxis === "x")) {
          this.dragPosition.y = this.dragStart.y + this.dragOffset.y;
        }

        this.dragPosition.scale = this.dragStart.scale * this.dragOffset.scale;

        if (currentPointers.length > 1) {
          const startPoint = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_4__.getMidpoint)(pointerTracker.startPointers[0], pointerTracker.startPointers[1]);

          const xPos = startPoint.clientX - this.dragStart.rect.x;
          const yPos = startPoint.clientY - this.dragStart.rect.y;

          const { deltaX, deltaY } = this.getZoomDelta(this.content.scale * this.dragOffset.scale, xPos, yPos);

          this.dragPosition.x -= deltaX;
          this.dragPosition.y -= deltaY;

          this.dragPosition.midPoint = newMidpoint;
        } else {
          this.setDragResistance();
        }

        // Update final position
        this.transform = {
          x: this.dragPosition.x,
          y: this.dragPosition.y,
          scale: this.dragPosition.scale,
        };

        this.startAnimation();
      },
      end: (pointer, event) => {
        if (this.state !== "pointerdown") {
          return;
        }

        this._dragOffset = { ...this.dragOffset };

        if (pointerTracker.currentPointers.length) {
          this.resetDragPosition();

          return;
        }

        this.state = "decel";
        this.friction = this.option("decelFriction");

        this.recalculateTransform();

        this.$container.classList.remove(this.option("draggingClass"));

        if (this.trigger("touchEnd", event) === false) {
          return;
        }

        if (this.state !== "decel") {
          return;
        }

        // * Check if scaled content past limits

        // Below minimum
        const minScale = this.option("minScale");

        if (this.transform.scale < minScale) {
          this.zoomTo(minScale, { friction: 0.64 });

          return;
        }

        // Exceed maximum
        const maxScale = this.option("maxScale");

        if (this.transform.scale - maxScale > 0.01) {
          const last = this.dragPosition.midPoint || pointer;
          const rect = this.$content.getClientRects()[0];

          this.zoomTo(maxScale, {
            friction: 0.64,
            x: last.clientX - rect.left,
            y: last.clientY - rect.top,
          });

          return;
        }
      },
    });

    this.pointerTracker = pointerTracker;
  }

  initObserver() {
    if (this.resizeObserver) {
      return;
    }

    this.resizeObserver = new _shared_utils_ResizeObserver_js__WEBPACK_IMPORTED_MODULE_3__.ResizeObserver(() => {
      if (this.updateTimer) {
        return;
      }

      this.updateTimer = setTimeout(() => {
        const rect = this.$container.getBoundingClientRect();

        if (!(rect.width && rect.height)) {
          this.updateTimer = null;
          return;
        }

        // Check to see if there are any changes
        if (Math.abs(rect.width - this.container.width) > 1 || Math.abs(rect.height - this.container.height) > 1) {
          if (this.isAnimating()) {
            this.endAnimation(true);
          }

          this.updateMetrics();

          this.panTo({
            x: this.content.x,
            y: this.content.y,
            scale: this.option("baseScale"),
            friction: 0,
          });
        }

        this.updateTimer = null;
      }, this.updateRate);
    });

    this.resizeObserver.observe(this.$container);
  }

  /**
   * Restore drag related variables to default values
   */
  resetDragPosition() {
    this.lockAxis = null;
    this.friction = this.option("friction");

    this.velocity = {
      x: 0,
      y: 0,
      scale: 0,
    };

    const { x, y, scale } = this.content;

    this.dragStart = {
      rect: this.$content.getBoundingClientRect(),
      x,
      y,
      scale,
    };

    this.dragPosition = {
      ...this.dragPosition,
      x,
      y,
      scale,
    };

    this.dragOffset = {
      x: 0,
      y: 0,
      scale: 1,
      time: 0,
    };
  }

  /**
   * Trigger update events before/after resizing content and viewport
   * @param {Boolean} silently Should trigger `afterUpdate` event at the end
   */
  updateMetrics(silently) {
    if (silently !== true) {
      this.trigger("beforeUpdate");
    }

    const $container = this.$container;
    const $content = this.$content;
    const $viewport = this.$viewport;

    const contentIsImage = $content instanceof HTMLImageElement;
    const contentIsZoomable = this.option("zoom");
    const shouldResizeParent = this.option("resizeParent", contentIsZoomable);

    let width = this.option("width");
    let height = this.option("height");

    let origWidth = width || (0,_shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__.getFullWidth)($content);
    let origHeight = height || (0,_shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__.getFullHeight)($content);

    Object.assign($content.style, {
      width: width ? `${width}px` : "",
      height: height ? `${height}px` : "",
      maxWidth: "",
      maxHeight: "",
    });

    if (shouldResizeParent) {
      Object.assign($viewport.style, { width: "", height: "" });
    }

    const ratio = this.option("ratio");

    origWidth = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(origWidth * ratio);
    origHeight = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(origHeight * ratio);

    width = origWidth;
    height = origHeight;

    const contentRect = $content.getBoundingClientRect();
    const viewportRect = $viewport.getBoundingClientRect();

    const containerRect = $viewport == $container ? viewportRect : $container.getBoundingClientRect();

    let viewportWidth = Math.max($viewport.offsetWidth, (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(viewportRect.width));
    let viewportHeight = Math.max($viewport.offsetHeight, (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(viewportRect.height));

    let viewportStyles = window.getComputedStyle($viewport);
    viewportWidth -= parseFloat(viewportStyles.paddingLeft) + parseFloat(viewportStyles.paddingRight);
    viewportHeight -= parseFloat(viewportStyles.paddingTop) + parseFloat(viewportStyles.paddingBottom);

    this.viewport.width = viewportWidth;
    this.viewport.height = viewportHeight;

    if (contentIsZoomable) {
      if (Math.abs(origWidth - contentRect.width) > 0.1 || Math.abs(origHeight - contentRect.height) > 0.1) {
        const rez = (0,_shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__.calculateAspectRatioFit)(
          origWidth,
          origHeight,
          Math.min(origWidth, contentRect.width),
          Math.min(origHeight, contentRect.height)
        );

        width = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(rez.width);
        height = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(rez.height);
      }

      Object.assign($content.style, {
        width: `${width}px`,
        height: `${height}px`,
        transform: "",
      });
    }

    if (shouldResizeParent) {
      Object.assign($viewport.style, { width: `${width}px`, height: `${height}px` });

      this.viewport = { ...this.viewport, width, height };
    }

    if (contentIsImage && contentIsZoomable && typeof this.options.maxScale !== "function") {
      const maxScale = this.option("maxScale");

      this.options.maxScale = function () {
        return this.content.origWidth > 0 && this.content.fitWidth > 0
          ? this.content.origWidth / this.content.fitWidth
          : maxScale;
      };
    }

    this.content = {
      ...this.content,
      origWidth,
      origHeight,
      fitWidth: width,
      fitHeight: height,
      width,
      height,
      scale: 1,
      isZoomable: contentIsZoomable,
    };

    this.container = { width: containerRect.width, height: containerRect.height };

    if (silently !== true) {
      this.trigger("afterUpdate");
    }
  }

  /**
   * Increase zoom level
   * @param {Number} [step] Zoom ratio; `0.5` would increase scale from 1 to 1.5
   */
  zoomIn(step) {
    this.zoomTo(this.content.scale + (step || this.option("step")));
  }

  /**
   * Decrease zoom level
   * @param {Number} [step] Zoom ratio; `0.5` would decrease scale from 1.5 to 1
   */
  zoomOut(step) {
    this.zoomTo(this.content.scale - (step || this.option("step")));
  }

  /**
   * Toggles zoom level between max and base levels
   * @param {Object} [options] Additional options
   */
  toggleZoom(props = {}) {
    const maxScale = this.option("maxScale");
    const baseScale = this.option("baseScale");

    const scale = this.content.scale > baseScale + (maxScale - baseScale) * 0.5 ? baseScale : maxScale;

    this.zoomTo(scale, props);
  }

  /**
   * Animate to given zoom level
   * @param {Number} scale New zoom level
   * @param {Object} [options] Additional options
   */
  zoomTo(scale = this.option("baseScale"), { x = null, y = null } = {}) {
    scale = Math.max(Math.min(scale, this.option("maxScale")), this.option("minScale"));

    // Adjust zoom position
    const currentScale = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.scale / (this.content.width / this.content.fitWidth), 10000000);

    if (x === null) {
      x = this.content.width * currentScale * 0.5;
    }

    if (y === null) {
      y = this.content.height * currentScale * 0.5;
    }

    const { deltaX, deltaY } = this.getZoomDelta(scale, x, y);

    x = this.content.x - deltaX;
    y = this.content.y - deltaY;

    this.panTo({ x, y, scale, friction: this.option("zoomFriction") });
  }

  /**
   * Calculate difference for top/left values if content would scale at given coordinates
   * @param {Number} scale
   * @param {Number} x
   * @param {Number} y
   * @returns {Object}
   */
  getZoomDelta(scale, x = 0, y = 0) {
    const currentWidth = this.content.fitWidth * this.content.scale;
    const currentHeight = this.content.fitHeight * this.content.scale;

    const percentXInCurrentBox = x > 0 && currentWidth ? x / currentWidth : 0;
    const percentYInCurrentBox = y > 0 && currentHeight ? y / currentHeight : 0;

    const nextWidth = this.content.fitWidth * scale;
    const nextHeight = this.content.fitHeight * scale;

    const deltaX = (nextWidth - currentWidth) * percentXInCurrentBox;
    const deltaY = (nextHeight - currentHeight) * percentYInCurrentBox;

    return { deltaX, deltaY };
  }

  /**
   * Animate to given positon and/or zoom level
   * @param {Object} [options] Additional options
   */
  panTo({
    x = this.content.x,
    y = this.content.y,
    scale,
    friction = this.option("friction"),
    ignoreBounds = false,
  } = {}) {
    scale = scale || this.content.scale || 1;

    if (!ignoreBounds) {
      const { boundX, boundY } = this.getBounds(scale);

      if (boundX) {
        x = Math.max(Math.min(x, boundX.to), boundX.from);
      }

      if (boundY) {
        y = Math.max(Math.min(y, boundY.to), boundY.from);
      }
    }

    this.friction = friction;

    this.transform = {
      ...this.transform,
      x,
      y,
      scale,
    };

    if (friction) {
      this.state = "panning";

      this.velocity = {
        x: (1 / this.friction - 1) * (x - this.content.x),
        y: (1 / this.friction - 1) * (y - this.content.y),
        scale: (1 / this.friction - 1) * (scale - this.content.scale),
      };

      this.startAnimation();
    } else {
      this.endAnimation();
    }
  }

  /**
   * Start animation loop
   */
  startAnimation() {
    if (!this.rAF) {
      this.trigger("startAnimation");
    } else {
      cancelAnimationFrame(this.rAF);
    }

    this.rAF = requestAnimationFrame(() => this.animate());
  }

  /**
   * Process animation frame
   */
  animate() {
    this.setEdgeForce();
    this.setDragForce();

    this.velocity.x *= this.friction;
    this.velocity.y *= this.friction;

    this.velocity.scale *= this.friction;

    this.content.x += this.velocity.x;
    this.content.y += this.velocity.y;

    this.content.scale += this.velocity.scale;

    if (this.isAnimating()) {
      this.setTransform();
    } else if (this.state !== "pointerdown") {
      this.endAnimation();

      return;
    }

    this.rAF = requestAnimationFrame(() => this.animate());
  }

  /**
   * Calculate boundaries
   */
  getBounds(scale) {
    let boundX = this.boundX;
    let boundY = this.boundY;

    if (boundX !== undefined && boundY !== undefined) {
      return { boundX, boundY };
    }

    boundX = { from: 0, to: 0 };
    boundY = { from: 0, to: 0 };

    scale = scale || this.transform.scale;

    const width = this.content.fitWidth * scale;
    const height = this.content.fitHeight * scale;

    const viewportWidth = this.viewport.width;
    const viewportHeight = this.viewport.height;

    if (width < viewportWidth) {
      const deltaX = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)((viewportWidth - width) * 0.5);

      boundX.from = deltaX;
      boundX.to = deltaX;
    } else {
      boundX.from = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(viewportWidth - width);
    }

    if (height < viewportHeight) {
      const deltaY = (viewportHeight - height) * 0.5;

      boundY.from = deltaY;
      boundY.to = deltaY;
    } else {
      boundY.from = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(viewportHeight - height);
    }

    return { boundX, boundY };
  }

  /**
   * Change animation velocity if boundary is reached
   */
  setEdgeForce() {
    if (this.state !== "decel") {
      return;
    }

    const bounceForce = this.option("bounceForce");

    const { boundX, boundY } = this.getBounds(Math.max(this.transform.scale, this.content.scale));

    let pastLeft, pastRight, pastTop, pastBottom;

    if (boundX) {
      pastLeft = this.content.x < boundX.from;
      pastRight = this.content.x > boundX.to;
    }

    if (boundY) {
      pastTop = this.content.y < boundY.from;
      pastBottom = this.content.y > boundY.to;
    }

    if (pastLeft || pastRight) {
      const bound = pastLeft ? boundX.from : boundX.to;
      const distance = bound - this.content.x;

      let force = distance * bounceForce;

      const restX = this.content.x + (this.velocity.x + force) / this.friction;

      if (restX >= boundX.from && restX <= boundX.to) {
        force += this.velocity.x;
      }

      this.velocity.x = force;

      this.recalculateTransform();
    }

    if (pastTop || pastBottom) {
      const bound = pastTop ? boundY.from : boundY.to;
      const distance = bound - this.content.y;

      let force = distance * bounceForce;

      const restY = this.content.y + (force + this.velocity.y) / this.friction;

      if (restY >= boundY.from && restY <= boundY.to) {
        force += this.velocity.y;
      }

      this.velocity.y = force;

      this.recalculateTransform();
    }
  }

  /**
   * Change dragging position if boundary is reached
   */
  setDragResistance() {
    if (this.state !== "pointerdown") {
      return;
    }

    const { boundX, boundY } = this.getBounds(this.dragPosition.scale);

    let pastLeft, pastRight, pastTop, pastBottom;

    if (boundX) {
      pastLeft = this.dragPosition.x < boundX.from;
      pastRight = this.dragPosition.x > boundX.to;
    }

    if (boundY) {
      pastTop = this.dragPosition.y < boundY.from;
      pastBottom = this.dragPosition.y > boundY.to;
    }

    if ((pastLeft || pastRight) && !(pastLeft && pastRight)) {
      const bound = pastLeft ? boundX.from : boundX.to;
      const distance = bound - this.dragPosition.x;

      this.dragPosition.x = bound - distance * 0.3;
    }

    if ((pastTop || pastBottom) && !(pastTop && pastBottom)) {
      const bound = pastTop ? boundY.from : boundY.to;
      const distance = bound - this.dragPosition.y;

      this.dragPosition.y = bound - distance * 0.3;
    }
  }

  /**
   * Set velocity to move content to drag position
   */
  setDragForce() {
    if (this.state === "pointerdown") {
      this.velocity.x = this.dragPosition.x - this.content.x;
      this.velocity.y = this.dragPosition.y - this.content.y;
      this.velocity.scale = this.dragPosition.scale - this.content.scale;
    }
  }

  /**
   * Update end values based on current velocity and friction;
   */
  recalculateTransform() {
    this.transform.x = this.content.x + this.velocity.x / (1 / this.friction - 1);
    this.transform.y = this.content.y + this.velocity.y / (1 / this.friction - 1);
    this.transform.scale = this.content.scale + this.velocity.scale / (1 / this.friction - 1);
  }

  /**
   * Check if content is currently animating
   * @returns {Boolean}
   */
  isAnimating() {
    return !!(
      this.friction &&
      (Math.abs(this.velocity.x) > 0.05 || Math.abs(this.velocity.y) > 0.05 || Math.abs(this.velocity.scale) > 0.05)
    );
  }

  /**
   * Set content `style.transform` value based on current animation frame
   */
  setTransform(final) {
    let x, y, scale;

    if (final) {
      x = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.transform.x);
      y = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.transform.y);

      scale = this.transform.scale;

      this.content = { ...this.content, x, y, scale };
    } else {
      x = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.x);
      y = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.y);

      scale = this.content.scale / (this.content.width / this.content.fitWidth);

      this.content = { ...this.content, x, y };
    }

    this.trigger("beforeTransform");

    x = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.x);
    y = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.y);

    if (final && this.option("zoom")) {
      let width;
      let height;

      width = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.fitWidth * scale);
      height = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.fitHeight * scale);

      this.content.width = width;
      this.content.height = height;

      this.transform = { ...this.transform, width, height, scale };

      Object.assign(this.$content.style, {
        width: `${width}px`,
        height: `${height}px`,
        maxWidth: "none",
        maxHeight: "none",
        transform: `translate3d(${x}px, ${y}px, 0) scale(1)`,
      });
    } else {
      this.$content.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${scale})`;
    }

    this.trigger("afterTransform");
  }

  /**
   * Stop animation loop
   */
  endAnimation(silently) {
    cancelAnimationFrame(this.rAF);
    this.rAF = null;

    this.velocity = {
      x: 0,
      y: 0,
      scale: 0,
    };

    this.setTransform(true);

    this.state = "ready";

    this.handleCursor();

    if (silently !== true) {
      this.trigger("endAnimation");
    }
  }

  /**
   * Update the class name depending on whether the content is scaled
   */
  handleCursor() {
    const draggableClass = this.option("draggableClass");

    if (!draggableClass || !this.option("touch")) {
      return;
    }

    if (
      this.option("panOnlyZoomed") == true &&
      this.content.width <= this.viewport.width &&
      this.content.height <= this.viewport.height &&
      this.transform.scale <= this.option("baseScale")
    ) {
      this.$container.classList.remove(draggableClass);
    } else {
      this.$container.classList.add(draggableClass);
    }
  }

  /**
   * Remove observation and detach event listeners
   */
  detachEvents() {
    this.$content.removeEventListener("load", this.onLoad);

    this.$container.removeEventListener("wheel", this.onWheel, { passive: false });
    this.$container.removeEventListener("click", this.onClick, { passive: false });

    if (this.pointerTracker) {
      this.pointerTracker.stop();
      this.pointerTracker = null;
    }

    if (this.resizeObserver) {
      this.resizeObserver.disconnect();
      this.resizeObserver = null;
    }
  }

  /**
   * Clean up
   */
  destroy() {
    if (this.state === "destroy") {
      return;
    }

    this.state = "destroy";

    clearTimeout(this.updateTimer);
    this.updateTimer = null;

    cancelAnimationFrame(this.rAF);
    this.rAF = null;

    this.detachEvents();

    this.detachPlugins();

    this.resetDragPosition();
  }
}

// Expose version
Panzoom.version = "__VERSION__";

// Static properties are a recent addition that dont work in all browsers yet
Panzoom.Plugins = _plugins_index_js__WEBPACK_IMPORTED_MODULE_8__.Plugins;


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/Panzoom/plugins/index.js":
/*!******************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/Panzoom/plugins/index.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Plugins": function() { return /* binding */ Plugins; }
/* harmony export */ });
const Plugins = {};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/Base/Base.js":
/*!*************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/Base/Base.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Base": function() { return /* binding */ Base; }
/* harmony export */ });
/* harmony import */ var _utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/extend.js */ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _utils_resolve_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/resolve.js */ "../node_modules/@fancyapps/ui/src/shared/utils/resolve.js");
/* harmony import */ var _utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/isPlainObject.js */ "../node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js");




/**
 * Base class, all components inherit from this class
 */
class Base {
  /**
   * Base constructor
   * @param {Object} [options] - Options as `key: value` pairs
   */
  constructor(options = {}) {
    this.options = (0,_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, {}, options);

    this.plugins = [];
    this.events = {};

    // * Prefill with initial events
    for (const type of ["on", "once"]) {
      for (const args of Object.entries(this.options[type] || {})) {
        this[type](...args);
      }
    }
  }

  /**
   * Retrieve option value by key, supports subkeys
   * @param {String} key Option name
   * @param {*} [fallback] Fallback value for non-existing key
   * @returns {*}
   */
  option(key, fallback, ...rest) {
    // Make sure it is string
    key = String(key);

    let value = (0,_utils_resolve_js__WEBPACK_IMPORTED_MODULE_1__.resolve)(key, this.options);

    // Allow to have functions as options
    if (typeof value === "function") {
      value = value.call(this, this, ...rest);
    }

    return value === undefined ? fallback : value;
  }

  /**
   * Simple l10n support - replaces object keys
   * found in template with corresponding values
   * @param {String} str String containing values to localize
   * @param {Array} params Substitute parameters
   * @returns {String}
   */
  localize(str, params = []) {
    str = String(str).replace(/\{\{(\w+).?(\w+)?\}\}/g, (match, key, subkey) => {
      let rez = "";

      // Plugins have `Plugin.l10n.KEY`
      if (subkey) {
        rez = this.option(`${key[0] + key.toLowerCase().substring(1)}.l10n.${subkey}`);
      } else if (key) {
        rez = this.option(`l10n.${key}`);
      }

      if (!rez) {
        rez = match;
      }

      for (let index = 0; index < params.length; index++) {
        rez = rez.split(params[index][0]).join(params[index][1]);
      }

      return rez;
    });

    str = str.replace(/\{\{(.*)\}\}/, (match, key) => {
      return key;
    });

    return str;
  }

  /**
   * Subscribe to an event
   * @param {String} name
   * @param {Function} callback
   * @returns {Object}
   */
  on(name, callback) {
    if ((0,_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__.isPlainObject)(name)) {
      for (const args of Object.entries(name)) {
        this.on(...args);
      }

      return this;
    }

    String(name)
      .split(" ")
      .forEach((item) => {
        const listeners = (this.events[item] = this.events[item] || []);

        if (listeners.indexOf(callback) == -1) {
          listeners.push(callback);
        }
      });

    return this;
  }

  /**
   * Subscribe to an event only once
   * @param {String} name
   * @param {Function} callback
   * @returns {Object}
   */
  once(name, callback) {
    if ((0,_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__.isPlainObject)(name)) {
      for (const args of Object.entries(name)) {
        this.once(...args);
      }

      return this;
    }

    String(name)
      .split(" ")
      .forEach((item) => {
        const listener = (...details) => {
          this.off(item, listener);
          callback.call(this, this, ...details);
        };

        listener._ = callback;

        this.on(item, listener);
      });

    return this;
  }

  /**
   * Unsubscribe event with name and callback
   * @param {String} name
   * @param {Function} callback
   * @returns {Object}
   */
  off(name, callback) {
    if ((0,_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__.isPlainObject)(name)) {
      for (const args of Object.entries(name)) {
        this.off(...args);
      }

      return;
    }

    name.split(" ").forEach((item) => {
      const listeners = this.events[item];

      if (!listeners || !listeners.length) {
        return this;
      }

      let index = -1;

      for (let i = 0, len = listeners.length; i < len; i++) {
        const listener = listeners[i];

        if (listener && (listener === callback || listener._ === callback)) {
          index = i;
          break;
        }
      }

      if (index != -1) {
        listeners.splice(index, 1);
      }
    });

    return this;
  }

  /**
   * Emit an event.
   * If present, `"*"` handlers are invoked after name-matched handlers.
   * @param {String} name
   * @param  {...any} details
   * @returns {Boolean}
   */
  trigger(name, ...details) {
    for (const listener of [...(this.events[name] || [])].slice()) {
      if (listener && listener.call(this, this, ...details) === false) {
        return false;
      }
    }

    // A wildcard "*" event type
    for (const listener of [...(this.events["*"] || [])].slice()) {
      if (listener && listener.call(this, name, this, ...details) === false) {
        return false;
      }
    }

    return true;
  }

  /**
   * Add given plugins to this instance,
   * this will end up calling `attach` method of each plugin
   * @param {Object} Plugins
   * @returns {Object}
   */
  attachPlugins(plugins) {
    const newPlugins = {};

    for (const [key, Plugin] of Object.entries(plugins || {})) {
      // Check if this plugin is not disabled by option
      if (this.options[key] !== false && !this.plugins[key]) {
        // Populate options with defaults from the plugin
        this.options[key] = (0,_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, Plugin.defaults || {}, this.options[key]);

        // Initialise plugin
        newPlugins[key] = new Plugin(this);
      }
    }

    for (const [key, plugin] of Object.entries(newPlugins)) {
      plugin.attach(this);
    }

    this.plugins = Object.assign({}, this.plugins, newPlugins);

    return this;
  }

  /**
   * Remove all plugin instances from this instance,
   * this will end up calling `detach` method of each plugin
   * @returns {Object}
   */
  detachPlugins() {
    for (const key in this.plugins) {
      let plugin;

      if ((plugin = this.plugins[key]) && typeof plugin.detach === "function") {
        plugin.detach(this);
      }
    }

    this.plugins = {};

    return this;
  }
}


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/Fullscreen.js":
/*!********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/Fullscreen.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Fullscreen": function() { return /* binding */ Fullscreen; }
/* harmony export */ });
const Fullscreen = {
  pageXOffset: 0,
  pageYOffset: 0,

  element() {
    return document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement;
  },

  activate(element) {
    Fullscreen.pageXOffset = window.pageXOffset;
    Fullscreen.pageYOffset = window.pageYOffset;

    if (element.requestFullscreen) {
      element.requestFullscreen(); // W3C spec
    } else if (element.mozRequestFullScreen) {
      element.mozRequestFullScreen(); // Firefox
    } else if (element.webkitRequestFullscreen) {
      element.webkitRequestFullscreen(); // Safari
    } else if (element.msRequestFullscreen) {
      element.msRequestFullscreen(); // IE/Edge
    }
  },

  deactivate() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  },
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/PointerTracker.js":
/*!************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/PointerTracker.js ***!
  \************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "PointerTracker": function() { return /* binding */ PointerTracker; },
/* harmony export */   "getDistance": function() { return /* binding */ getDistance; },
/* harmony export */   "getMidpoint": function() { return /* binding */ getMidpoint; }
/* harmony export */ });
class Pointer {
  constructor(nativePointer) {
    this.id = self.Touch && nativePointer instanceof Touch ? nativePointer.identifier : -1;

    this.pageX = nativePointer.pageX;
    this.pageY = nativePointer.pageY;

    this.clientX = nativePointer.clientX;
    this.clientY = nativePointer.clientY;
  }
}

const getDistance = (a, b) => {
  if (!b) {
    return 0;
  }

  return Math.sqrt((b.clientX - a.clientX) ** 2 + (b.clientY - a.clientY) ** 2);
};

const getMidpoint = (a, b) => {
  if (!b) {
    return a;
  }

  return {
    clientX: (a.clientX + b.clientX) / 2,
    clientY: (a.clientY + b.clientY) / 2,
  };
};

const isTouchEvent = (event) => "changedTouches" in event;

class PointerTracker {
  constructor(_element, { start = () => true, move = () => {}, end = () => {} } = {}) {
    this._element = _element;

    this.startPointers = [];
    this.currentPointers = [];

    this._pointerStart = (event) => {
      if (event.buttons > 0 && event.button !== 0) {
        return;
      }

      const pointer = new Pointer(event);

      if (this.currentPointers.some((p) => p.id === pointer.id)) {
        return;
      }

      if (!this._triggerPointerStart(pointer, event)) {
        return;
      }

      window.addEventListener("mousemove", this._move);
      window.addEventListener("mouseup", this._pointerEnd);
    };

    this._touchStart = (event) => {
      for (const touch of Array.from(event.changedTouches || [])) {
        this._triggerPointerStart(new Pointer(touch), event);
      }
    };

    this._move = (event) => {
      const previousPointers = this.currentPointers.slice();
      const changedPointers = isTouchEvent(event)
        ? Array.from(event.changedTouches).map((t) => new Pointer(t))
        : [new Pointer(event)];

      const trackedChangedPointers = [];

      for (const pointer of changedPointers) {
        const index = this.currentPointers.findIndex((p) => p.id === pointer.id);

        if (index < 0) {
          continue;
        }

        trackedChangedPointers.push(pointer);

        this.currentPointers[index] = pointer;
      }

      this._moveCallback(previousPointers, this.currentPointers.slice(), event);
    };

    this._triggerPointerEnd = (pointer, event) => {
      const index = this.currentPointers.findIndex((p) => p.id === pointer.id);

      if (index < 0) {
        return false;
      }

      this.currentPointers.splice(index, 1);
      this.startPointers.splice(index, 1);

      this._endCallback(pointer, event);

      return true;
    };

    this._pointerEnd = (event) => {
      if (event.buttons > 0 && event.button !== 0) {
        return;
      }

      if (!this._triggerPointerEnd(new Pointer(event), event)) {
        return;
      }

      window.removeEventListener("mousemove", this._move, { passive: false });
      window.removeEventListener("mouseup", this._pointerEnd, { passive: false });
    };

    this._touchEnd = (event) => {
      for (const touch of Array.from(event.changedTouches || [])) {
        this._triggerPointerEnd(new Pointer(touch), event);
      }
    };

    this._startCallback = start;
    this._moveCallback = move;
    this._endCallback = end;

    this._element.addEventListener("mousedown", this._pointerStart, { passive: false });
    this._element.addEventListener("touchstart", this._touchStart, { passive: false });
    this._element.addEventListener("touchmove", this._move, { passive: false });
    this._element.addEventListener("touchend", this._touchEnd);
    this._element.addEventListener("touchcancel", this._touchEnd);
  }

  stop() {
    this._element.removeEventListener("mousedown", this._pointerStart, { passive: false });
    this._element.removeEventListener("touchstart", this._touchStart, { passive: false });
    this._element.removeEventListener("touchmove", this._move, { passive: false });
    this._element.removeEventListener("touchend", this._touchEnd);
    this._element.removeEventListener("touchcancel", this._touchEnd);

    window.removeEventListener("mousemove", this._move);
    window.removeEventListener("mouseup", this._pointerEnd);
  }

  _triggerPointerStart(pointer, event) {
    if (!this._startCallback(pointer, event)) {
      return false;
    }

    this.currentPointers.push(pointer);
    this.startPointers.push(pointer);

    return true;
  }
}




/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/ResizeObserver.js":
/*!************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/ResizeObserver.js ***!
  \************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ResizeObserver": function() { return /* binding */ ResizeObserver; }
/* harmony export */ });
/**
 * ResizeObserver Polyfill
 */
const ResizeObserver =
  (typeof window !== "undefined" && window.ResizeObserver) ||
  class {
    constructor(callback) {
      this.observables = [];
      // Array of observed elements that looks like this:
      // [{
      //   el: domNode,
      //   size: {height: x, width: y}
      // }]
      this.boundCheck = this.check.bind(this);
      this.boundCheck();
      this.callback = callback;
    }

    observe(el) {
      if (this.observables.some((observable) => observable.el === el)) {
        return;
      }

      const newObservable = {
        el: el,
        size: {
          height: el.clientHeight,
          width: el.clientWidth,
        },
      };

      this.observables.push(newObservable);
    }

    unobserve(el) {
      this.observables = this.observables.filter((obj) => obj.el !== el);
    }

    disconnect() {
      this.observables = [];
    }

    check() {
      const changedEntries = this.observables
        .filter((obj) => {
          const currentHeight = obj.el.clientHeight;
          const currentWidth = obj.el.clientWidth;
          if (obj.size.height !== currentHeight || obj.size.width !== currentWidth) {
            obj.size.height = currentHeight;
            obj.size.width = currentWidth;
            return true;
          }
        })
        .map((obj) => obj.el);

      if (changedEntries.length > 0) {
        this.callback(changedEntries);
      }

      window.requestAnimationFrame(this.boundCheck);
    }
  };


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/Slideshow.js":
/*!*******************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/Slideshow.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Slideshow": function() { return /* binding */ Slideshow; }
/* harmony export */ });
class Slideshow {
  constructor(fancybox) {
    this.fancybox = fancybox;
    this.active = false;

    this.handleVisibilityChange = this.handleVisibilityChange.bind(this);
  }

  isActive() {
    return this.active;
  }

  setTimer() {
    if (!this.active || this.timer) {
      return;
    }

    const delay = this.fancybox.option("slideshow.delay", 3000);

    this.timer = setTimeout(() => {
      this.timer = null;

      if (
        !this.fancybox.option("infinite") &&
        this.fancybox.getSlide().index === this.fancybox.Carousel.slides.length - 1
      ) {
        this.fancybox.jumpTo(0, { friction: 0 });
      } else {
        this.fancybox.next();
      }
    }, delay);

    let $progress = this.$progress;

    if (!$progress) {
      $progress = document.createElement("div");
      $progress.classList.add("fancybox__progress");

      this.fancybox.$carousel.parentNode.insertBefore($progress, this.fancybox.$carousel);

      this.$progress = $progress;

      $progress.offsetHeight; /* trigger reflow */
    }

    $progress.style.transitionDuration = `${delay}ms`;
    $progress.style.transform = "scaleX(1)";
  }

  clearTimer() {
    clearTimeout(this.timer);
    this.timer = null;

    if (this.$progress) {
      this.$progress.style.transitionDuration = "";
      this.$progress.style.transform = "";

      this.$progress.offsetHeight; /* trigger reflow */
    }
  }

  activate() {
    if (this.active) {
      return;
    }

    this.active = true;
    this.fancybox.$container.classList.add("has-slideshow");

    if (this.fancybox.getSlide().state === "done") {
      this.setTimer();
    }

    document.addEventListener("visibilitychange", this.handleVisibilityChange, false);
  }

  handleVisibilityChange() {
    this.deactivate();
  }

  deactivate() {
    this.active = false;

    this.clearTimer();

    this.fancybox.$container.classList.remove("has-slideshow");

    document.removeEventListener("visibilitychange", this.handleVisibilityChange, false);
  }

  toggle() {
    if (this.active) {
      this.deactivate();
    } else if (this.fancybox.Carousel.slides.length > 1) {
      this.activate();
    }
  }
}


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js":
/*!*******************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "canUseDOM": function() { return /* binding */ canUseDOM; }
/* harmony export */ });
/**
 * Detect if rendering from the client or the server
 */
const canUseDOM = !!(typeof window !== "undefined" && window.document && window.document.createElement);


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/extend.js":
/*!****************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/extend.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "extend": function() { return /* binding */ extend; }
/* harmony export */ });
/* harmony import */ var _isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isPlainObject.js */ "../node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js");


/**
 * Merge the contents of two or more objects together into the first object.
 * If passing "true" for first argument, the merge becomes recursive (aka. deep copy).
 * @param  {...any} args
 * @returns {Object}
 */
const extend = (...args) => {
  let deep = false;

  if (typeof args[0] == "boolean") {
    deep = args.shift();
  }

  let result = args[0];

  if (!result || typeof result !== "object") {
    throw new Error("extendee must be an object");
  }

  const extenders = args.slice(1);
  const len = extenders.length;

  for (let i = 0; i < len; i++) {
    const extender = extenders[i];

    for (let key in extender) {
      if (extender.hasOwnProperty(key)) {
        const value = extender[key];

        if (deep && (Array.isArray(value) || (0,_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__.isPlainObject)(value))) {
          const base = Array.isArray(value) ? [] : {};

          result[key] = extend(true, result.hasOwnProperty(key) ? result[key] : base, value);
        } else {
          result[key] = value;
        }
      }
    }
  }

  return result;
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/getDimensions.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/getDimensions.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "calculateAspectRatioFit": function() { return /* binding */ calculateAspectRatioFit; },
/* harmony export */   "getFullHeight": function() { return /* binding */ getFullHeight; },
/* harmony export */   "getFullWidth": function() { return /* binding */ getFullWidth; }
/* harmony export */ });
/**
 * Get actual width of the element, regardless of how much of content is currently visible
 * @param {Element} elem
 * @returns {Integer}
 */
const getFullWidth = (elem) => {
  return Math.max(
    parseFloat(elem.naturalWidth || 0),
    parseFloat((elem.width && elem.width.baseVal && elem.width.baseVal.value) || 0),
    parseFloat(elem.offsetWidth || 0),
    parseFloat(elem.scrollWidth || 0)
  );
};

/**
 * Get actual height of the element, regardless of how much of content is currently visible
 * @param {Element} elem
 * @returns {Integer}
 */
const getFullHeight = (elem) => {
  return Math.max(
    parseFloat(elem.naturalHeight || 0),
    parseFloat((elem.height && elem.height.baseVal && elem.height.baseVal.value) || 0),
    parseFloat(elem.offsetHeight || 0),
    parseFloat(elem.scrollHeight || 0)
  );
};

/**
 * Calculate bounding size to fit dimensions while preserving aspect ratio
 * @param {Number} srcWidth
 * @param {Number} srcHeight
 * @param {Number} maxWidth
 * @param {Number} maxHeight
 * @returns {Object}
 */
const calculateAspectRatioFit = (srcWidth, srcHeight, maxWidth, maxHeight) => {
  const ratio = Math.min(maxWidth / srcWidth || 0, maxHeight / srcHeight);

  return { width: srcWidth * ratio || 0, height: srcHeight * ratio || 0 };
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/getTextNodeFromPoint.js":
/*!******************************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/getTextNodeFromPoint.js ***!
  \******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getTextNodeFromPoint": function() { return /* binding */ getTextNodeFromPoint; }
/* harmony export */ });
/**
 * Get element child node at the given coordinates
 * @param {Element} HTML element
 * @param {Float|Integer} x
 * @param {Float|Integer} y
 * @returns {Node|Boolean}}
 */
const getTextNodeFromPoint = (element, x, y) => {
  const nodes = element.childNodes;
  const range = document.createRange();

  for (let i = 0; i < nodes.length; i++) {
    const node = nodes[i];

    if (node.nodeType !== Node.TEXT_NODE) {
      continue;
    }

    range.selectNodeContents(node);

    const rect = range.getBoundingClientRect();

    if (x >= rect.left && y >= rect.top && x <= rect.right && y <= rect.bottom) {
      return node;
    }
  }

  return false;
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isPlainObject": function() { return /* binding */ isPlainObject; }
/* harmony export */ });
/**
 * Check to see if an object is a plain object (created using "{}" or "new Object").
 * @param {*} obj Variable of any type
 * @returns {Boolean}
 */
const isPlainObject = (obj) => {
  return (
    // separate from primitives
    typeof obj === "object" &&
    // is obvious
    obj !== null &&
    // separate instances (Array, DOM, ...)
    obj.constructor === Object &&
    // separate build-in like Math
    Object.prototype.toString.call(obj) === "[object Object]"
  );
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js":
/*!**********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isScrollable": function() { return /* binding */ isScrollable; }
/* harmony export */ });
/* unused harmony export hasScrollbars */
/**
 * Check if  element has scrollable content
 * @param {Node} node
 * @returns {Boolean}
 */
const hasScrollbars = function (node) {
  const overflowY = getComputedStyle(node)["overflow-y"],
    overflowX = getComputedStyle(node)["overflow-x"],
    vertical = (overflowY === "scroll" || overflowY === "auto") && Math.abs(node.scrollHeight - node.clientHeight) > 1,
    horizontal = (overflowX === "scroll" || overflowX === "auto") && Math.abs(node.scrollWidth - node.clientWidth) > 1;

  return vertical || horizontal;
};

/**
 * Check if element or one of the parents is scrollable
 * @param {Node} node  DOM Node element
 * @returns {Boolean}
 */
const isScrollable = function (node) {
  if (!node || !(typeof node === "object" && node instanceof Element) || node === document.body) {
    return false;
  }

  if (node.__Panzoom) {
    return false;
  }

  if (hasScrollbars(node)) {
    return node;
  }

  return isScrollable(node.parentNode);
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/resolve.js":
/*!*****************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/resolve.js ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "resolve": function() { return /* binding */ resolve; }
/* harmony export */ });
/**
 * Access nested JavaScript objects by string path.
 * Example: `resolve("a.b.c", {a:{b:{c:"d"}})` would return `d`
 * @param {String} path
 * @param {Object} obj
 * @returns {*}
 */
const resolve = function (path, obj) {
  return path.split(".").reduce(function (prev, curr) {
    return prev && prev[curr];
  }, obj);
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/round.js":
/*!***************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/round.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "round": function() { return /* binding */ round; }
/* harmony export */ });
/**
 * Round half up; to be more specific and to ensure things like 1.005 round correctly
 * @param {Float} value
 * @param {Integer} precision
 * @returns {Float}
 */
const round = (value, precision = 10000) => {
  value = parseFloat(value) || 0;

  return Math.round((value + Number.EPSILON) * precision) / precision;
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/setFocusOn.js":
/*!********************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/setFocusOn.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "FOCUSABLE_ELEMENTS": function() { return /* binding */ FOCUSABLE_ELEMENTS; },
/* harmony export */   "setFocusOn": function() { return /* binding */ setFocusOn; }
/* harmony export */ });
/* harmony import */ var _canUseDOM_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./canUseDOM.js */ "../node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js");


let preventScrollSupported = null;

const FOCUSABLE_ELEMENTS = [
  "a[href]",
  "area[href]",
  'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',
  "select:not([disabled]):not([aria-hidden])",
  "textarea:not([disabled]):not([aria-hidden])",
  "button:not([disabled]):not([aria-hidden])",
  "iframe",
  "object",
  "embed",
  "video",
  "audio",
  "[contenteditable]",
  '[tabindex]:not([tabindex^="-"]):not([disabled]):not([aria-hidden])',
];

const setFocusOn = (node) => {
  if (!node || !_canUseDOM_js__WEBPACK_IMPORTED_MODULE_0__.canUseDOM) {
    return;
  }

  if (preventScrollSupported === null) {
    document.createElement("div").focus({
      get preventScroll() {
        preventScrollSupported = true;

        return false;
      },
    });
  }

  try {
    if (node.setActive) {
      // IE/Edge
      node.setActive();
    } else if (preventScrollSupported) {
      // Modern browsers
      node.focus({ preventScroll: true });
    } else {
      // Safari does not support `preventScroll` option
      // https://bugs.webkit.org/show_bug.cgi?id=178583

      // Save position
      const scrollTop = window.pageXOffset || document.body.scrollTop;
      const scrollLeft = window.pageYOffset || document.body.scrollLeft;

      node.focus();

      document.body.scrollTo({
        top: scrollTop,
        left: scrollLeft,
        behavior: "auto",
      });
    }
  } catch (e) {}
};


/***/ }),

/***/ "../node_modules/@fancyapps/ui/src/shared/utils/throttle.js":
/*!******************************************************************!*\
  !*** ../node_modules/@fancyapps/ui/src/shared/utils/throttle.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "throttle": function() { return /* binding */ throttle; }
/* harmony export */ });
/**
 * Throttling enforces a maximum number of times a function can be called over time
 * @param {Function} func Callback function
 * @param {Integer} limit Milliseconds
 * @returns {Function}
 */
const throttle = (func, limit) => {
  let lastCall = 0;

  return function (...args) {
    const now = new Date().getTime();

    if (now - lastCall < limit) {
      return;
    }

    lastCall = now;

    return func(...args);
  };
};


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
!function() {
/*!*****************************!*\
  !*** ./js/plugins/modal.js ***!
  \*****************************/
/* harmony import */ var _fancyapps_ui_src_Fancybox_Fancybox_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @fancyapps/ui/src/Fancybox/Fancybox.js */ "../node_modules/@fancyapps/ui/src/Fancybox/Fancybox.js");
/** ============================================================================
 * fancybox
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

rwp = typeof rwp === 'undefined' ? {} : rwp;

rwp.modal = function () {
  var selector = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '[data-fancybox]';
  var args = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var defaults = {
    template: '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
    on: {
      load: function load(instance, slide) {
        console.log("#".concat(slide.index, " slide is loaded!"));
        console.log("This slide is selected: ".concat(instance.getSlide().index === slide.index));
      }
    }
  };

  if (!rwp.isEmpty(args)) {
    args = rwp.defaultsDeep(args, defaults);
  } else {
    args = defaults;
  }

  if (!rwp.isEmpty(selector)) {
    var modal = new _fancyapps_ui_src_Fancybox_Fancybox_js__WEBPACK_IMPORTED_MODULE_0__.Fancybox(selector, args);
    return modal;
  }
};
}();
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
!function() {
/*!********************************!*\
  !*** ./css/plugins/modal.scss ***!
  \********************************/
// extracted by mini-css-extract-plugin

}();
/******/ })()
;
//# sourceMappingURL=rwp-modal.js.map