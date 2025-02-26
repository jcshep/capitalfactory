document.addEventListener('DOMContentLoaded', function () {
    const industrySelect = document.getElementById('industry-select');
    const technologySelect = document.getElementById('technology-select');
    const fundSelect = document.getElementById('fund-select');
    const resetButton = document.querySelector('#filter a.btn');
    const startupItems = document.querySelectorAll('.startup-item');
    const startupContainer = document.getElementById('startups-container');

    // Function to get URL parameters
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Function to update URL with current filters
    function updateUrlParameters() {
        const industry = industrySelect.value;
        const technology = technologySelect.value;
        const fund = fundSelect.value;
        
        let url = new URL(window.location);
        
        // Update or remove parameters based on selection
        if (industry) {
            url.searchParams.set('industry', industry);
        } else {
            url.searchParams.delete('industry');
        }
        
        if (technology) {
            url.searchParams.set('technology', technology);
        } else {
            url.searchParams.delete('technology');
        }
        
        if (fund) {
            url.searchParams.set('fund', fund);
        } else {
            url.searchParams.delete('fund');
        }
        
        // Update URL without reloading the page
        window.history.pushState({}, '', url);
    }

    // Function to filter startups
    function filterStartups(updateUrl = true) {
        const selectedIndustry = industrySelect.value;
        const selectedTechnology = technologySelect.value;
        const selectedFund = fundSelect.value;

        let visibleCount = 0;
        let visibleItems = [];

        // First determine which items should be visible
        startupItems.forEach(item => {
            const industries = item.dataset.industries.split(' ');
            const technologies = item.dataset.technologies.split(' ');
            const funds = item.dataset.funds.split(' ');

            // Check if the startup matches all selected filters
            const matchesIndustry = !selectedIndustry || industries.includes(selectedIndustry);
            const matchesTechnology = !selectedTechnology || technologies.includes(selectedTechnology);
            const matchesFund = !selectedFund || funds.includes(selectedFund);

            if (matchesIndustry && matchesTechnology && matchesFund) {
                visibleItems.push(item);
                visibleCount++;
            }
        });

        // Clear the container
        startupContainer.innerHTML = '';
        
        // If no items match, show message
        if (visibleCount === 0) {
            const message = document.createElement('div');
            message.className = 'col-12 no-results-message';
            message.innerHTML = '<p>No startups match the selected filters.</p>';
            startupContainer.appendChild(message);
            return;
        }
        
        // Add all visible items to the single row container
        visibleItems.forEach(item => {
            // Clone the item to avoid reference issues
            const clonedItem = item.cloneNode(true);
            clonedItem.style.display = ''; // Ensure it's visible
            startupContainer.appendChild(clonedItem);
        });
        
        // Update URL parameters if needed
        if (updateUrl) {
            updateUrlParameters();
        }
    }

    // Reset all filters
    function resetFilters(e) {
        e.preventDefault();
        industrySelect.value = '';
        technologySelect.value = '';
        fundSelect.value = '';
        filterStartups();
    }

    // Apply URL parameters on page load
    function applyUrlParameters() {
        const industry = getUrlParameter('industry');
        const technology = getUrlParameter('technology');
        const fund = getUrlParameter('fund');
        
        let filtersApplied = false;
        
        if (industry && document.querySelector(`#industry-select option[value="${industry}"]`)) {
            industrySelect.value = industry;
            filtersApplied = true;
        }
        
        if (technology && document.querySelector(`#technology-select option[value="${technology}"]`)) {
            technologySelect.value = technology;
            filtersApplied = true;
        }
        
        if (fund && document.querySelector(`#fund-select option[value="${fund}"]`)) {
            fundSelect.value = fund;
            filtersApplied = true;
        }
        
        // Only filter if parameters were applied
        if (filtersApplied) {
            filterStartups(false); // Don't update URL when applying initial parameters
        }
    }

    // Add event listeners to the select elements
    industrySelect.addEventListener('change', () => filterStartups());
    technologySelect.addEventListener('change', () => filterStartups());
    fundSelect.addEventListener('change', () => filterStartups());
    
    // Add event listener to reset button
    if (resetButton) {
        resetButton.addEventListener('click', resetFilters);
    }
    
    // Apply URL parameters on page load
    applyUrlParameters();
});
