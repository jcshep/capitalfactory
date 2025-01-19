class Menu {
  constructor(e) {
    this.el = e;
    this.isOpen;
    this.current;
    this.getElements();
    this.setEvents();
  }

  getElements() {
    this.links = this.el.querySelectorAll("ul#menu-main > li > a");
    this.panels = this.el.querySelectorAll("li .sub-menu");
  }

  setEvents() {
    this.links.forEach((e) => {
      e.addEventListener("click", this.mouseEnter.bind(this));
        e.addEventListener("mouseenter", this.mouseEnter.bind(this));
        e.addEventListener("focus", this.mouseEnter.bind(this));
        e.addEventListener("mouseleave", this.mouseLeave.bind(this));
    }),
    
    this.panels.forEach((e) => {
      const title = e.parentElement.querySelector('a').innerText;
      const first = e.querySelector('li');
      e.addEventListener("mouseleave", this.mouseLeave.bind(this)); 
      e.addEventListener("mouseenter", this.mouseEnter.bind(this));
    });
  }

  mouseEnter(e) {
  	if (e.currentTarget.parentNode.parentNode.parentNode.classList.contains('.sub-menu')) {
  		this.open(e.currentTarget.parentNode.parentNode.parentNode);
  	} else {
  		this.open(e.currentTarget.parentNode);
  	}
  }

  mouseLeave(e) {
    this.closeAll();
  }

  open(e) {
    this.current != e && (this.closeAll(), (this.isOpen = !0), e.classList.add("has-hover"), document.body.classList.add("menu-open"), (this.current = e));
  }

  closeAll() {
    for (let i= 0; i < this.links.length; i++) this.close(this.links[i].parentNode);
    document.body.classList.remove("menu-open"), (this.current = null);
  }

  close(e) {
    (this.isOpen = !1), (this.isOpen && this.current == e) || e.classList.remove("has-hover");
  }
}

document.addEventListener("DOMContentLoaded", function() {
  new Menu(document.querySelector('header .main-menu'));
})
