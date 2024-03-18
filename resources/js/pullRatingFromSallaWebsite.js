fetch('https://valinteca.com/empty/public/api/safwat-aljawf.com/rating/clear?url=' + window.location.href, {
    method: 'POST'
}).then(function (response) {
    console.log('clear done');
});

function contains(selector, text) {
    var elements = document.querySelectorAll(selector);
    return Array.prototype.filter.call(elements, function (element) {
        return RegExp(text).test(element.textContent);
    });
}


var selector = contains('span', 'تحميل المزيد')[0];
if (selector) {

    var still = true,
        setEv = setInterval(function () {
            var P_selector = document.querySelector('.pagination__next');
            if (P_selector) {
                if (P_selector.style.display === 'none') {
                    console.log('none');
                    setTimeout(function () {
                        pullRatings();
                    }, 3000);

                    clearInterval(setEv);
                } else {
                    console.log('still');
                    selector.click();
                }


            }

        }, 2000);


}


function pullRatings() {
    console.log('pullRatings Started');
    var contentSelector = document.querySelectorAll('.view-comment__comment');
    if (!contentSelector) {
        console.log(contentSelector)
        return;
    }
    contentSelector.forEach(function (tag) {
        var content = tag.querySelector('.comment-content').innerText;
        var rating = tag.querySelector('.rating');
        var stars = 0;
        if (rating) {
            rating.querySelectorAll('span').forEach(function (item) {
                if (item.classList.contains('checked')) {
                    stars++;
                }

            });
            fetch('https://valinteca.com/empty/public/api/safwat-aljawf.com/rating?url=' + window.location.href + '&content=' + content + '&stars=' + stars, {
                method: 'POST'
            }).then(function (response) {
                console.log('done');
            });
        }


    });
}
