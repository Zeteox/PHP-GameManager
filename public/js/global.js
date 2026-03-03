document.addEventListener("DOMContentLoaded", () => {
  const currentUrl = window.location.pathname.split("/").pop() || "index.php";
  const links = document.querySelectorAll(".nav-link");
  links.forEach((link) => {
    const linkHref = link.getAttribute("href");
    if (currentUrl === linkHref) {
      link.classList.add("nav-link-active");
      link.classList.remove("text-[#f0d8a8]");
    }
  });
});

function switchTab(tab) {
  const formLogin = document.getElementById("form-login");
  const formRegister = document.getElementById("form-register");
  const tabLogin = document.getElementById("tab-login");
  const tabRegister = document.getElementById("tab-register");

  if (tab === "login") {
    formLogin.classList.remove("hidden");
    formLogin.classList.add("block");
    formRegister.classList.remove("block");
    formRegister.classList.add("hidden");

    tabLogin.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#ffd700] bg-[#2d1e12] border-t-2 border-[#ffd700] transition-colors font-serif";
    tabRegister.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#b8860b] hover:text-[#f0d8a8] bg-[#1a120b] border-t-2 border-transparent transition-colors font-serif cursor-pointer";
  } else {
    formRegister.classList.remove("hidden");
    formRegister.classList.add("block");
    formLogin.classList.remove("block");
    formLogin.classList.add("hidden");

    tabRegister.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#ffd700] bg-[#2d1e12] border-t-2 border-[#ffd700] transition-colors font-serif";
    tabLogin.className =
      "flex-1 py-4 font-black uppercase tracking-widest text-[#b8860b] hover:text-[#f0d8a8] bg-[#1a120b] border-t-2 border-transparent transition-colors font-serif cursor-pointer";
  }
}
