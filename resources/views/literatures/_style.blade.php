<style>
    /* Hilangkan tombol clear bawaan browser pada input search */
    input[type="search"]::-webkit-search-decoration,
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-results-button,
    input[type="search"]::-webkit-search-results-decoration {
        -webkit-appearance: none;
        appearance: none;
    }

    input[type="search"]::-ms-clear,
    input[type="search"]::-ms-reveal {
        display: none;
        width: 0;
        height: 0;
    }

    /* Efek loading ketika AJAX berjalan */
    #resultsContainer.is-loading {
        opacity: 0.5;
        pointer-events: none;
        transition: opacity 0.15s ease-out;
    }
</style>