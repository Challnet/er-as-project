class ViewModal {
  constructor() {
    this.modal = document.getElementById("content-modal");
    this.btn = document.getElementById("open-modal-btn");
    this.closeBtn = this.modal?.querySelector(".modal-close");

    if (!this.modal || !this.btn || !this.closeBtn) return;

    this.bindEvents();
  }

  bindEvents() {
    this.btn.addEventListener("click", () => this.open());
    this.closeBtn.addEventListener("click", () => this.close());

    // закрытие по клику вне окна
    this.modal.addEventListener("click", (e) => {
      if (e.target === this.modal) this.close();
    });

    // закрытие ESC
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") this.close();
    });
  }

  open() {
    this.modal.classList.add("visible");
  }

  close() {
    this.modal.classList.remove("visible");
  }
}

export default ViewModal;
