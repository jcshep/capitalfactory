document.addEventListener('DOMContentLoaded', function () {
    // const industrySelect = document.getElementById('industry-select');
    const technologySelect = document.getElementById('technology-select');
    const specialtySelect = document.getElementById('specialty-select');
    const productTypeSelect = document.getElementById('product-type-select');
    const resetButton = document.querySelector('#filter a.btn');
    const mentorItems = document.querySelectorAll('.mentor-card');
    const mentorContainer = document.querySelector('.row:has(.mentor-card)');

    // Function to get URL parameters
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Function to update URL with current filters
    function updateUrlParameters() {
        // const industry = industrySelect.value;
        const technology = technologySelect.value;
        const specialty = specialtySelect.value;
        const productType = productTypeSelect.value;
        
        let url = new URL(window.location);
        
        // Update or remove parameters based on selection
        // if (industry) {
        //     url.searchParams.set('industry', industry);
        // } else {
        //     url.searchParams.delete('industry');
        // }
        
        if (technology) {
            url.searchParams.set('technology', technology);
        } else {
            url.searchParams.delete('technology');
        }
        
        if (specialty) {
            url.searchParams.set('specialty', specialty);
        } else {
            url.searchParams.delete('specialty');
        }
        
        if (productType) {
            url.searchParams.set('product-type', productType);
        } else {
            url.searchParams.delete('product-type');
        }
        
        // Update URL without reloading the page
        window.history.pushState({}, '', url);
    }

    // Function to filter mentors
    function filterMentors(updateUrl = true) {
        // const selectedIndustry = industrySelect.value;
        const selectedTechnology = technologySelect.value;
        const selectedSpecialty = specialtySelect.value;
        const selectedProductType = productTypeSelect.value;

        let visibleCount = 0;
        let visibleItems = [];

        // First determine which items should be visible
        mentorItems.forEach(item => {
            // const industries = item.dataset.industry ? item.dataset.industry.split(' ') : [];
            const technologies = item.dataset.technology ? item.dataset.technology.split(' ') : [];
            const specialties = item.dataset.specialty ? item.dataset.specialty.split(' ') : [];
            const productTypes = item.dataset.productType ? item.dataset.productType.split(' ') : [];

            // Check if the mentor matches all selected filters
            // const matchesIndustry = !selectedIndustry || industries.includes(selectedIndustry);
            const matchesTechnology = !selectedTechnology || technologies.includes(selectedTechnology);
            const matchesSpecialty = !selectedSpecialty || specialties.includes(selectedSpecialty);
            const matchesProductType = !selectedProductType || productTypes.includes(selectedProductType);

            if (/* matchesIndustry && */ matchesTechnology && matchesSpecialty && matchesProductType) {
                visibleItems.push(item);
                visibleCount++;
            }
        });

        // Hide all items first
        mentorItems.forEach(item => {
            item.parentElement.style.display = 'none';
        });
        
        // If no items match, show message
        if (visibleCount === 0) {
            if (!document.querySelector('.no-results-message')) {
                const message = document.createElement('div');
                message.className = 'col-12 no-results-message';
                message.innerHTML = '<p>No mentors match the selected filters.</p>';
                mentorContainer.appendChild(message);
            }
        } else {
            // Remove any existing no results message
            const noResultsMessage = document.querySelector('.no-results-message');
            if (noResultsMessage) {
                noResultsMessage.remove();
            }
            
            // Show all visible items
            visibleItems.forEach(item => {
                item.parentElement.style.display = '';
            });
        }
        
        // Update URL parameters if needed
        if (updateUrl) {
            updateUrlParameters();
        }
    }

    // Reset all filters
    function resetFilters(e) {
        e.preventDefault();
        // industrySelect.value = '';
        technologySelect.value = '';
        specialtySelect.value = '';
        productTypeSelect.value = '';
        
        // Show all items
        mentorItems.forEach(item => {
            item.parentElement.style.display = '';
        });
        
        // Remove any existing no results message
        const noResultsMessage = document.querySelector('.no-results-message');
        if (noResultsMessage) {
            noResultsMessage.remove();
        }
        
        // Update URL
        updateUrlParameters();
    }

    // Apply URL parameters on page load
    function applyUrlParameters() {
        // const industry = getUrlParameter('industry');
        const technology = getUrlParameter('technology');
        const specialty = getUrlParameter('specialty');
        const productType = getUrlParameter('product-type');
        
        let filtersApplied = false;
        
        // if (industry && document.querySelector(`#industry-select option[value="${industry}"]`)) {
        //     industrySelect.value = industry;
        //     filtersApplied = true;
        // }
        
        if (technology && document.querySelector(`#technology-select option[value="${technology}"]`)) {
            technologySelect.value = technology;
            filtersApplied = true;
        }
        
        if (specialty && document.querySelector(`#specialty-select option[value="${specialty}"]`)) {
            specialtySelect.value = specialty;
            filtersApplied = true;
        }
        
        if (productType && document.querySelector(`#product-type-select option[value="${productType}"]`)) {
            productTypeSelect.value = productType;
            filtersApplied = true;
        }
        
        // Only filter if parameters were applied
        if (filtersApplied) {
            filterMentors(false); // Don't update URL when applying initial parameters
        }
    }

    // Add event listeners to the select elements
    // if (industrySelect) {
    //     industrySelect.addEventListener('change', () => filterMentors());
    // }
    
    if (technologySelect) {
        technologySelect.addEventListener('change', () => filterMentors());
    }
    
    if (specialtySelect) {
        specialtySelect.addEventListener('change', () => filterMentors());
    }
    
    if (productTypeSelect) {
        productTypeSelect.addEventListener('change', () => filterMentors());
    }
    
    // Add event listener to reset button
    if (resetButton) {
        resetButton.addEventListener('click', resetFilters);
    }
    
    // Apply URL parameters on page load
    applyUrlParameters();
});
