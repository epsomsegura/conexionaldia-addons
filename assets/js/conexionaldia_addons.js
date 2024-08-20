document.addEventListener('DOMContentLoaded', () => {
    let uri = conexionaldia_addons_object.api_url;
    fetch(uri, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(response => response.json())
        .then((addon) => {
            addon.payload = JSON.parse(addon.payload);
            setAddons(addon.payload);

        }).catch((error) => {
        });
});

function setAddons(addons) {
    document.querySelector('.header-right').innerHTML = '<img class="img-link" src="' + addons.header.path + '" ' + (addons.header.url != null ? 'style="width:100%;max-width:728px;cursor:pointer;" data-url="' + addons.header.url + '"' : '') + ' />';
    var wrapper = document.querySelector('.boxed-content-wrapper');
    var sidebars = wrapper.querySelectorAll('.mom_contet_e3lanat');
    var spaceDivider = document.querySelector('div[style="margin-top:-17px; margin-bottom:20px;"]');
    if (sidebars.length > 0) {
        sidebars.forEach((element) => {
            element.remove();
        });
    }
    let rightSidebarContainer = document.createElement("div");
    rightSidebarContainer.classList.add("mom_contet_e3lanat");
    rightSidebarContainer.classList.add("mc_e3lan-right");
    rightSidebarContainer.classList.add("mca-fixed");
    let rightSidebar = '<div class="mom-e3lanat-wrap"> <div class="mom-e3lanat"> <div class="mom-e3lanat-inner">';
    (addons.right).forEach((addon, index) => {
        rightSidebar += '<div class="mom-e3lan mom_e3lan-empty border-box" style="margin-bottom:10px;cursor:pointer;">';
        rightSidebar += '<img class="img-link" src="' + addon.path + '" ' + ((addon.url != null) ? 'style="max-width:234px;cursor:pointer;" data-url="' + addon.url + '"' : '') + ' />';
        if (addon.url != null) { rightSidebar += '<a href="' + addon.url + '" target="_BLANK" class="overlay"></a>'; }
        rightSidebar += '</div>';
    });
    rightSidebar += '</div> </div> </div>';
    rightSidebarContainer.innerHTML = rightSidebar;
    spaceDivider.after(rightSidebarContainer);
    let leftSidebarContainer = document.createElement("div");
    leftSidebarContainer.classList.add("mom_contet_e3lanat");
    leftSidebarContainer.classList.add("mc_e3lan-left");
    leftSidebarContainer.classList.add("mca-fixed");
    let leftSidebar = '<div class="mom-e3lanat-wrap"> <div class="mom-e3lanat"> <div class="mom-e3lanat-inner">';
    (addons.left).forEach((addon, index) => {
        leftSidebar += '<div class="mom-e3lan mom_e3lan-empty border-box" style="margin-bottom:10px;cursor:pointer;">';
        leftSidebar += '<img class="img-link" src="' + addon.path + '" ' + ((addon.url != null) ? 'style="max-width:234px;cursor:pointer;" data-url="' + addon.url + '"' : '') + '  />';
        if (addon.url != null) { leftSidebar += '<a href="' + addon.url + '" target="_BLANK" class="overlay"></a>'; }
        leftSidebar += '</div>';
    });
    leftSidebar += '</div> </div> </div>';
    leftSidebarContainer.innerHTML = leftSidebar;
    rightSidebarContainer.after(leftSidebarContainer)

    let clicableImages = document.querySelectorAll('.img-link');
    clicableImages.forEach((image) => {
        if (image.hasAttribute('data-url')) {
            image.addEventListener('click', () => {
                let href = image.dataset['url'];
                if (href != null || href != undefined) {
                    window.open(href, '_BLANK');
                }
            });
        }
    });

    let breakingNews = document.querySelector('.breaking-news').getBoundingClientRect().top;
    window.addEventListener("scroll", (event) => {
        let scroll = this.scrollY;
        breakingNewsElements = document.querySelector('.breaking-news');
        if (scroll >= breakingNews) {
            breakingNewsElements.classList.add('news-fixed-top');
            wrapper.classList.add('fixed-top-margin');
        }
        else {
            breakingNewsElements.classList.remove('news-fixed-top');
            wrapper.classList.remove('fixed-top-margin');
        }
    });
}