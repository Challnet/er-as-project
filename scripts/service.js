class YearsAccordion {
  selectors = {
    root: "[data-js-years-list]",
    item: "[data-js-year-item]",
    button: "[data-js-year-button]",
    content: "[data-js-year-content]",
  };

  stateClasses = {
    open: "open",
  };

  constructor() {
    this.rootElement = document.querySelector(this.selectors.root);

    if (!this.rootElement) return;

    this.items = [...this.rootElement.querySelectorAll(this.selectors.item)];

    this.prepareItems();
    this.bindEvents();
  }

  prepareItems() {
    this.items.forEach(item => {
      const content = item.querySelector(this.selectors.content);
      content.style.maxHeight = "0px";
      content.style.overflow = "hidden";
      content.style.transition = "max-height 0.35s ease";
    });
  }

  bindEvents() {
    this.items.forEach(item => {
      const button = item.querySelector(this.selectors.button);
      button?.addEventListener("click", () => this.toggleItem(item));
    });
  }

  toggleItem(clickedItem) {
    const isOpen = clickedItem.classList.contains(this.stateClasses.open);

    this.items.forEach(item => {
      if (item !== clickedItem) this.closeItem(item);
    });

    isOpen ? this.closeItem(clickedItem) : this.openItem(clickedItem);
  }

  openItem(item) {
    item.classList.add(this.stateClasses.open);
    const content = item.querySelector(this.selectors.content);
    content.style.maxHeight = content.scrollHeight + "px";
  }

  closeItem(item) {
    item.classList.remove(this.stateClasses.open);
    const content = item.querySelector(this.selectors.content);
    content.style.maxHeight = "0px";
  }
}

export default YearsAccordion;
