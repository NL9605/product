document.querySelectorAll('.product-card img').forEach((img) => {
    const originalSrc = img.src;
    const hoverSrc = img.getAttribute('data-hover-image');

    img.addEventListener('mouseenter', () => {
        img.src = hoverSrc;
    });

    img.addEventListener('mouseleave', () => {
        img.src = originalSrc;
    });
});


const modal = document.getElementById('quick-view-modal');
const closeModal = document.querySelector('.close');
const modalProductName = document.getElementById('modal-product-name');
const modalProductDescription = document.getElementById('modal-product-description');
const modalProductPrice = document.getElementById('modal-product-price');
const modalProductImage = document.getElementById('modal-product-image');
const modalProductColors = document.getElementById('modal-product-color');
const selectedColorName = document.getElementById('selected-color-name');
const thumbnailsContainer = document.getElementById('image-thumbnails');

document.querySelectorAll('.quick-view').forEach((quickView) => {
    quickView.addEventListener('click', () => {
        modalProductName.textContent = quickView.getAttribute('data-name');
        modalProductDescription.innerHTML = quickView.getAttribute('data-description');
        modalProductPrice.textContent = quickView.getAttribute('data-price');
        const imageUrls = quickView.getAttribute('data-image').split(',');
        modalProductImage.src = imageUrls[0];

        thumbnailsContainer.innerHTML = '';
        imageUrls.forEach((url) => {
            const button = document.createElement('button');
            button.style.backgroundImage = `url(${url})`;
            button.addEventListener('click', () => {
                modalProductImage.src = url;
            });
            thumbnailsContainer.appendChild(button);
        });

        const colors = quickView.getAttribute('data-colors').split(',');
        modalProductColors.innerHTML = '';
        colors.forEach((color) => {
            const colorBox = document.createElement('div');
            colorBox.className = 'color-box';
            colorBox.style.backgroundColor = color;
            modalProductColors.appendChild(colorBox);
        });

        selectedColorName.textContent = colors.length > 0 ? 'Selected color' : 'No colors available';
        modal.style.display = 'block';
    });
});

closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});