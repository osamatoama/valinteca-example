var selectors = document.querySelectorAll('.panel.panel-default.feedback'),
    ratings = [];


function storeRatings() {
    selectors.forEach(function (item) {
        var type = item.querySelector(".badge.badge--grey.without-hover.font-12.text-default").innerText,
            stars = item.querySelectorAll('.rating-stars .star-on').length;
        ratings.push({
            'rating_type': type,
            'stars': stars
        });

        fetch('https://valinteca.com/empty/public/api/abaya/rating/store',
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    'rating_type': type,
                    'stars': stars
                })


            });


    });

    nextPage();

}

function nextPage() {
    console.log('nextPage triggered')

    setTimeout(function () {
        var liSelector = document.querySelector('li.page-item.active ~ li:not(.disabled) .page-link');
        if (liSelector) {
            liSelector.click();
            setTimeout(function () {
                storeRatings();

            }, 4000);
        }
    }, 10000);
}


storeRatings();

















// Define the URL for the API request
const url = "https://example.valinteca.com/api/any";

// Define the headers for the API request
const headers = {
    // "Content-Type": "application/json"
};

// Define the body of the API request
const body = {
    // Include the HTML body from the input data
    "data": 'Hello' //inputData["html body"]
};

// Make a POST request to the API with the defined URL, headers, and body



document.querySelectorAll('img').forEach(function (item) {

    fetch('https://example.valinteca.com/api/pull-nava-images',
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                'url': item.src,

            })
        });
});



