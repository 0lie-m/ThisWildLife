document.addEventListener("DOMContentLoaded", function () {
  /*
   * Hero slideshow
   */
  const slides = document.querySelectorAll(".slide");
  let currentSlide = 0;

  if (slides.length > 0) {
    setInterval(() => {
      slides[currentSlide].classList.remove("active");

      currentSlide = (currentSlide + 1) % slides.length;

      slides[currentSlide].classList.add("active");
    }, 5000);
  }

  /*
   * Book carousel
   */
  const booksViewport = document.getElementById("booksViewport");
  const booksTrack = document.getElementById("booksTrack");
  const booksPrev = document.getElementById("booksPrev");
  const booksNext = document.getElementById("booksNext");
  const booksDots = document.getElementById("booksDots");

  if (
    booksViewport &&
    booksTrack &&
    booksPrev &&
    booksNext &&
    booksDots
  ) {
    const bookCards = Array.from(
      booksTrack.querySelectorAll(".book-card")
    );

    const visibleCards = () => {
      if (window.innerWidth <= 680) {
        return 1;
      }

      if (window.innerWidth <= 980) {
        return 2;
      }

      return 3;
    };

    const stepSize = () => {
      const firstCard = bookCards[0];

      if (!firstCard) {
        return booksViewport.clientWidth;
      }

      const gap = parseFloat(
        getComputedStyle(booksTrack).gap || "0"
      );

      return firstCard.getBoundingClientRect().width + gap;
    };

    const maxIndex = () => {
      return Math.max(0, bookCards.length - visibleCards());
    };

    const currentIndex = () => {
      const step = stepSize();

      if (step <= 0) {
        return 0;
      }

      return Math.round(booksViewport.scrollLeft / step);
    };

    const goToIndex = (index) => {
      const boundedIndex = Math.max(
        0,
        Math.min(index, maxIndex())
      );

      booksViewport.scrollTo({
        left: boundedIndex * stepSize(),
        behavior: "smooth",
      });
    };

    const renderDots = () => {
      booksDots.innerHTML = "";

      for (let index = 0; index <= maxIndex(); index += 1) {
        const dot = document.createElement("button");

        dot.type = "button";
        dot.setAttribute(
          "aria-label",
          `Go to book slide ${index + 1}`
        );

        dot.addEventListener("click", () => {
          goToIndex(index);
        });

        booksDots.appendChild(dot);
      }
    };

    const syncCarouselUi = () => {
      const index = currentIndex();

      booksPrev.disabled = index <= 0;
      booksNext.disabled = index >= maxIndex();

      Array.from(booksDots.children).forEach(
        (dot, dotIndex) => {
          dot.classList.toggle(
            "active",
            dotIndex === index
          );
        }
      );
    };

    booksPrev.addEventListener("click", () => {
      goToIndex(currentIndex() - 1);
    });

    booksNext.addEventListener("click", () => {
      goToIndex(currentIndex() + 1);
    });

    booksViewport.addEventListener(
      "scroll",
      syncCarouselUi
    );

    window.addEventListener("resize", () => {
      renderDots();
      goToIndex(currentIndex());
      syncCarouselUi();
    });

    renderDots();
    syncCarouselUi();
  }

  /*
   * Reveal animations
   */
  const revealItems = document.querySelectorAll(".reveal");

  const revealOnScroll = () => {
    revealItems.forEach((item) => {
      const itemTop = item.getBoundingClientRect().top;
      const trigger = window.innerHeight - 70;

      if (itemTop < trigger) {
        item.classList.add("show");
      }
    });
  };

  window.addEventListener("scroll", revealOnScroll);
  window.addEventListener("load", revealOnScroll);

  revealOnScroll();

  /*
   * Database-driven Book modal
   */
  const modal = document.getElementById("bookModal");
  const modalDialog = modal?.querySelector(".modal-dialog");

  const modalFrontCover =
    document.getElementById("modalFrontCover");

  const modalBookTitle =
    document.getElementById("modalBookTitle");

  const modalBookAuthor =
    document.getElementById("modalBookAuthor");

  const modalBookDesc =
    document.getElementById("modalBookDesc");

  const modalFormat =
    document.getElementById("modalFormat");

  const modalAgeRange =
    document.getElementById("modalAgeRange");

  const modalAvailability =
    document.getElementById("modalAvailability");

  const modalPrice =
    document.getElementById("modalPrice");

  const amazonLink =
    document.getElementById("amazonLink");

  const closeModalButton =
    document.getElementById("closeModalBtn");

  const closeModalButtonSecondary =
    document.getElementById(
      "closeModalBtnSecondary"
    );

  let previouslyFocusedElement = null;

  const openBook = (bookCard) => {
    if (!modal || !bookCard) {
      return;
    }

    const book = bookCard.dataset;

    previouslyFocusedElement = document.activeElement;

    if (modalFrontCover) {
      modalFrontCover.src = book.cover || "";
      modalFrontCover.alt =
        `${book.title || "Book"} front cover`;
    }

    if (modalBookTitle) {
      modalBookTitle.textContent =
        book.title || "Book";
    }

    if (modalBookAuthor) {
      modalBookAuthor.textContent =
        book.author || "";
    }

    if (modalBookDesc) {
      modalBookDesc.textContent =
        book.description || "";
    }

    if (modalFormat) {
      modalFormat.textContent =
        book.format || "Illustrated children's book";
    }

    if (modalAgeRange) {
      const minimumAge = book.minimumAge || "";
      const maximumAge = book.maximumAge || "";

      if (minimumAge && maximumAge) {
        modalAgeRange.textContent =
          `${minimumAge}–${maximumAge} years`;
      } else {
        modalAgeRange.textContent =
          "Age guidance unavailable";
      }
    }

    if (modalAvailability) {
      modalAvailability.textContent =
        book.availability || "Coming soon";
    }

    if (modalPrice) {
      const price = Number.parseFloat(book.price);

      if (Number.isFinite(price)) {
        modalPrice.textContent = `€${price.toFixed(2)}`;
        modalPrice.hidden = false;
      } else {
        modalPrice.textContent = "";
        modalPrice.hidden = true;
      }
    }

    if (amazonLink) {
      const amazonUrl = book.amazonUrl || "";

      if (amazonUrl && amazonUrl !== "#") {
        amazonLink.href = amazonUrl;
        amazonLink.hidden = false;
      } else {
        amazonLink.removeAttribute("href");
        amazonLink.hidden = true;
      }
    }

    modal.classList.add("show");
    modal.setAttribute("aria-hidden", "false");

    document.body.style.overflow = "hidden";

    if (closeModalButton) {
      closeModalButton.focus();
    }
  };

  const closeBook = () => {
    if (!modal) {
      return;
    }

    modal.classList.remove("show");
    modal.setAttribute("aria-hidden", "true");

    document.body.style.overflow = "";

    if (previouslyFocusedElement) {
      previouslyFocusedElement.focus();
    }
  };

  document
    .querySelectorAll(".book-card")
    .forEach((bookCard) => {
      bookCard.addEventListener("click", () => {
        openBook(bookCard);
      });

      bookCard.addEventListener("keydown", (event) => {
        if (
          event.key === "Enter" ||
          event.key === " "
        ) {
          event.preventDefault();
          openBook(bookCard);
        }
      });
    });

  if (closeModalButton) {
    closeModalButton.addEventListener(
      "click",
      closeBook
    );
  }

  if (closeModalButtonSecondary) {
    closeModalButtonSecondary.addEventListener(
      "click",
      closeBook
    );
  }

  if (modal) {
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        closeBook();
      }
    });
  }

  document.addEventListener("keydown", (event) => {
    if (
      event.key === "Escape" &&
      modal?.classList.contains("show")
    ) {
      closeBook();
    }
  });

  if (modalDialog) {
    modalDialog.addEventListener(
      "click",
      (event) => {
        event.stopPropagation();
      }
    );
  }
});