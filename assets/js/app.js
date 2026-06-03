document.addEventListener("DOMContentLoaded", function () {
  const productGrid = document.getElementById("productGrid");
  const searchInput = document.getElementById("searchInput");
  const categoryFilter = document.getElementById("categoryFilter");
  const categoryMenu = document.getElementById("categoryMenu");
  const menuToggle = document.getElementById("menuToggle");
  const mainNav = document.getElementById("mainNav");

  function getProductCards() {
    return document.querySelectorAll(".product-card");
  }

  function removeNoResultsMessage() {
    const existingMessage = document.querySelector(".no-products-message");
    if (existingMessage) {
      existingMessage.remove();
    }
  }

  function showNoResultsMessage() {
    if (!productGrid) return;

    const existingMessage = document.querySelector(".no-products-message");
    if (!existingMessage) {
      const message = document.createElement("p");
      message.className = "no-products-message";
      message.textContent = "Nema proizvoda za zadane kriterije pretrage.";
      productGrid.appendChild(message);
    }
  }

  function filterProducts() {
    const cards = getProductCards();
    const search = searchInput ? searchInput.value.trim().toLowerCase() : "";
    const selectedCategory = categoryFilter ? categoryFilter.value.toLowerCase() : "all";

    let visibleCount = 0;

    cards.forEach((card) => {
      const productName = (card.dataset.name || "").toLowerCase();
      const productCategories = (card.dataset.category || "").toLowerCase();

      const matchesSearch =
        search === "" || productName.includes(search);

      const matchesCategory =
        selectedCategory === "all" ||
        productCategories.split(" ").includes(selectedCategory);

      if (matchesSearch && matchesCategory) {
        card.style.display = "";
        visibleCount++;
      } else {
        card.style.display = "none";
      }
    });

    if (visibleCount === 0) {
      showNoResultsMessage();
    } else {
      removeNoResultsMessage();
    }
  }

  if (searchInput) {
    searchInput.addEventListener("input", filterProducts);
  }

  if (categoryFilter) {
    categoryFilter.addEventListener("change", function () {
      const selected = this.value;

      if (categoryMenu) {
        categoryMenu.querySelectorAll("li").forEach((li) => {
          li.classList.remove("active");
        });

        const activeItem = categoryMenu.querySelector(
          `li[data-category="${selected}"]`
        );

        if (activeItem) {
          activeItem.classList.add("active");
        }
      }

      filterProducts();
    });
  }

  if (categoryMenu) {
    categoryMenu.addEventListener("click", function (e) {
      if (e.target.tagName === "LI") {
        categoryMenu.querySelectorAll("li").forEach((li) => {
          li.classList.remove("active");
        });

        e.target.classList.add("active");

        const selected = e.target.dataset.category || "all";

        if (categoryFilter) {
          categoryFilter.value = selected;
        }

        filterProducts();
      }
    });
  }

  if (menuToggle && mainNav) {
    menuToggle.addEventListener("click", () => {
      mainNav.classList.toggle("open");
    });
  }

  filterProducts();
});