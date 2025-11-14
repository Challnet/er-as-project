class HeaderMenu {
  selectors = {
    root: "[data-js-header-menu]",
    link: "[data-js-header-menu-link]",
  };

  stateClasses = {
    isActive: "is-active",
  };

  constructor() {
    this.root = document.querySelector(this.selectors.root);
    if (!this.root) return;

    this.linkElements = this.root.querySelectorAll(this.selectors.link);

    this.bindEvents();
  }

  setActiveByCurrentURL() {
    const currentPath = window.location.pathname;

    this.linkElements.forEach((link) => {
      const linkPath = new URL(link.href).pathname;

      if (
        linkPath === currentPath ||
        (linkPath === "/index.html" && currentPath === "/")
      ) {
        link.classList.add(this.stateClasses.isActive);
      } else {
        link.classList.remove(this.stateClasses.isActive);
      }
    });
  }

  onLinkElement(element) {
    this.linkElements.forEach((link) =>
      link.classList.remove(this.stateClasses.isActive)
    );

    element.classList.add(this.stateClasses.isActive);
  }

  bindEvents() {
    this.setActiveByCurrentURL();

    this.linkElements.forEach((linkElement) => {
      linkElement.addEventListener("click", (event) => {
        this.onLinkElement(event.currentTarget);
      });
    });
  }
}

export default HeaderMenu;
