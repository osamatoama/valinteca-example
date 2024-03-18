fetch('https://valinteca.com/empty/public/api/safwat-aljawf.com/rating/dashboard/clear', {
    method: 'POST'
}).then(function (response) {
    console.log('clear done');
});

function nextPage() {
    var elLi = document.querySelector('.page-item.active ~ li');
    if (elLi.classList.contains('disabled')) {
        return 'last'
    }
    elLi.querySelector('a').click();
    return 'still';

}


function pullRatings() {
    console.log('pullRatings Started');
    var contentSelector = document.querySelectorAll('#rating_div .feedback');
    if (!contentSelector) {
        console.log(contentSelector)
        return;
    }
    contentSelector.forEach(function (tag) {
        var content = tag.querySelector('.rating-stars ~ p').innerText;
        var product_name = tag.querySelector('.rec-list .text-default').innerText;
        var rating = tag.querySelector('.rating-stars');
        var stars = 0;
        if (rating) {
            rating.querySelectorAll('i').forEach(function (item) {
                if (item.classList.contains('star-on')) {
                    stars++;
                }

            });

            fetch('https://valinteca.com/empty/public/api/safwat-aljawf.com/rating/dashboard?product_name=' + product_name + '&content=' + content + '&stars=' + stars, {
                method: 'POST'
            }).then(function (response) {
                console.log('done');
            });
        }


    });


    setTimeout(function () {
        var nexP = nextPage();
        console.log(nexP)
        if (nexP === 'last') {
            return;
        }
        setTimeout(function () {
            pullRatings();
        }, 5000);
    }, 5000);
}


pullRatings();



