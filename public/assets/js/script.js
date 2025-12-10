// Enhanced jQuery functionality for Sugar Sight Saver
$(document).ready(function() {
    // Initialize Owl Carousel
    initOwlCarousel();
    function initOwlCarousel() {
        $('.info-carousel').owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            autoHeight: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 1,
                    nav: true
                },
                1000: {
                    items: 1,
                    nav: true
                }
            }
        });
    }

    // Initialize Image Zoom functionality
    initImageZoom();
    function initImageZoom() {
        const $imageModal = $('#imageZoomModal');
        const $zoomedImage = $('#zoomedImage');
        const $closeImageBtn = $('#closeImageModal');

        // Handle click on carousel images and their containers
        $(document).on('click', '.carousel-image, .item', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Get image source - if clicked on container, find the image inside
            let $img = $(this);
            if (!$img.is('img')) {
                $img = $(this).find('.carousel-image');
            }

            if ($img.length === 0) return;

            // Use zoom source if available, otherwise use the original source
            const imageSrc = $img.attr('data-zoom-src') || $img.attr('src');
            const imageAlt = $img.attr('alt');

            // Show loading state
            $zoomedImage.attr('src', '').attr('alt', '');

            // Show the modal
            $imageModal.removeClass('hidden').addClass('flex');
            $('body').addClass('overflow-hidden'); // Prevent background scrolling

            // Load the image
            const img = new Image();
            img.onload = function() {
                $zoomedImage.attr('src', imageSrc).attr('alt', imageAlt);
            };
            img.onerror = function() {
                console.error('Failed to load image:', imageSrc);
                closeImageModal();
            };
            img.src = imageSrc;
        });

        function closeImageModal() {
            $imageModal.addClass('hidden').removeClass('flex');
            $('body').removeClass('overflow-hidden');
        }

        // Close modal when close button is clicked
        $closeImageBtn.click(function() {
            closeImageModal();
        });

        // Close modal when clicking on the zoomed image
        $zoomedImage.click(function() {
            closeImageModal();
        });

        // Close modal when clicking outside the image
        $imageModal.click(function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal when pressing ESC key and handle keyboard navigation
        $(document).keyup(function(e) {
            if ($imageModal.hasClass('flex')) {
                switch(e.key) {
                    case 'Escape':
                        closeImageModal();
                        break;
                    case 'ArrowLeft':
                    case 'ArrowRight':
                        // Navigate carousel when modal is open
                        $('.info-carousel').trigger(e.key === 'ArrowLeft' ? 'prev.owl.carousel' : 'next.owl.carousel');
                        break;
                }
            }
        });
    }

    // Modal functionality for "Know More" button
    initModal();
    function initModal() {
        const $modal = $('#knowMoreModal');
        const $openBtn = $('#knowMoreBtn');
        const $closeBtn = $('#closeModal');

        // Open modal when "Know More" button is clicked
        $openBtn.click(function(e) {
            e.preventDefault();
            $modal.removeClass('hidden').addClass('flex');
            $('body').addClass('overflow-hidden'); // Prevent background scrolling
        });

        // Close modal when close button is clicked
        $closeBtn.click(function() {
            $modal.addClass('hidden').removeClass('flex');
            $('body').removeClass('overflow-hidden'); // Restore background scrolling
        });

        // Close modal when clicking outside the modal content
        $modal.click(function(e) {
            if (e.target === this) {
                $modal.addClass('hidden').removeClass('flex');
                $('body').removeClass('overflow-hidden');
            }
        });

        // Close modal when pressing ESC key
        $(document).keyup(function(e) {
            if (e.key === 'Escape') {
                $modal.addClass('hidden').removeClass('flex');
                $('body').removeClass('overflow-hidden');
            }
        });
    }


    // Configuration
    // const CONFIG = {
    //     shareMessage: "🚨 Important Health Alert! 🚨\n\nDid you know diabetes can cause blindness? Learn how to protect your vision with Sugar Sight Saver.\n\n👁️ Free resources and information available\n📱 Get help now: " + window.location.href + "\n\n#DiabetesAwareness #SaveYourSight #SugarSightSaver",
    //     smsMessage: "Important: Diabetes can cause blindness. Learn how to protect your vision: " + window.location.href,
    //     qrCodeData: window.location.href + "?ref=qr"
    // };

    // // Initialize components
    // initQRCode();

    // // QR Code Generation and Download
    // function initQRCode() {
    //     try {
    //         const qr = qrcode(0, 'M');
    //         qr.addData(CONFIG.qrCodeData);
    //         qr.make();
    //         $('#qrcode').html(qr.createImgTag(12));

    //         // Add styling to QR code image
    //         $('#qrcode img').addClass('mx-auto rounded-lg shadow-md');
    //     } catch (error) {
    //         console.error('QR Code generation failed:', error);
    //         $('#qrcode').html('<div class="text-gray-500 text-center">QR Code unavailable</div>');
    //     }
    // }



    // Download QR Code functionality
    // $('#downloadQR').click(function() {
    //     const $button = $(this);
    //     const originalText = $button.html();

    //     // Show loading state
    //     $button.html('<span class="loading"></span> Generating...');
    //     $button.prop('disabled', true);

    //     setTimeout(() => {
    //         try {
    //             const canvas = document.createElement('canvas');
    //             const ctx = canvas.getContext('2d');
    //             const img = $('#qrcode img')[0];

    //             if (img) {
    //                 canvas.width = img.width;
    //                 canvas.height = img.height;
    //                 ctx.drawImage(img, 0, 0);

    //                 const link = document.createElement('a');
    //                 link.download = 'sugar-sight-saver-qr.png';
    //                 link.href = canvas.toDataURL();
    //                 link.click();

    //                 showNotification('QR Code downloaded successfully!', 'success');
    //             } else {
    //                 throw new Error('QR Code image not found');
    //             }
    //         } catch (error) {
    //             console.error('Download failed:', error);
    //             showNotification('Download failed. Please try again.', 'error');
    //         } finally {
    //             // Reset button state
    //             $button.html(originalText);
    //             $button.prop('disabled', false);
    //         }
    //     }, 1000);
    // });

    // Handle Yes/No buttons for eye check question
    $('#yesBtn').click(function() {
        $('#yesResponse').removeClass('hidden').addClass('animate-fade-in');
        $('#noResponse').addClass('hidden');
        $(this).addClass('ring-4 ring-green-300');
        $('#noBtn').removeClass('ring-4 ring-red-300');
    });

    $('#noBtn').click(function() {
        $('#noResponse').removeClass('hidden').addClass('animate-fade-in');
        $('#yesResponse').addClass('hidden');
        $(this).addClass('ring-4 ring-red-300');
        $('#yesBtn').removeClass('ring-4 ring-green-300');
    });

    // Handle place selection for hospitals
    $('#placeSelect').change(function() {
        const selectedPlace = $(this).val();
        const $hospitalList = $('#hospitalList');
        const $notAvailableMessage = $('#notAvailableMessage');
        const $tableBody = $('#hospitalTableBody');

        // Hospital data
        const hospitalData = {
            'rajkot': [
            { no: '1', hospital: 'Gadre Eye Care Centre', doctor: 'Dr. Sanjay Gadre<br>Dr. Dhruv Worah', phone: '<a href="tel:9099145126" class="text-blue-600 hover:text-blue-800 font-medium">90991 45126</a>' },
            { no: '2', hospital: 'Bhatt Eye Hospital', doctor: 'Dr. Manoj Bhatt<br>Dr. Darshan Bhatt', phone: '<a href="tel:8849373811" class="text-blue-600 hover:text-blue-800 font-medium">88493 73811</a>' },
            { no: '3', hospital: 'Dhruva/Agarwal Eye Hospital', doctor: 'Dr. Animesh Dhruva', phone: '<a href="tel:7845734301" class="text-blue-600 hover:text-blue-800 font-medium">78457 34301</a><br><a href="tel:02812464611" class="text-blue-600 hover:text-blue-800 font-medium">0281 2464611</a>' },
            { no: '4', hospital: 'Shivani Hospital', doctor: 'Dr. Chetan Hindocha', phone: '<a href="tel:9409579678" class="text-blue-600 hover:text-blue-800 font-medium">94095 79678</a>' },
            { no: '5', hospital: 'Retina Hospital', doctor: 'Dr. Mukesh Porwal<br>Dr. Swati Ramteke', phone: '<a href="tel:7600312221" class="text-blue-600 hover:text-blue-800 font-medium">76003 12221</a><br><a href="tel:9426212221" class="text-blue-600 hover:text-blue-800 font-medium">94262 12221</a>' },
            { no: '6', hospital: 'Dr. Milan\'s Retina Care Centre', doctor: 'Dr. Milan Thakkar', phone: '<a href="tel:02812465066" class="text-blue-600 hover:text-blue-800 font-medium">0281 2465066</a>' },
            { no: '7', hospital: 'Swaminarayan Gurukul Hospital', doctor: 'Dr. Harsh Yadav', phone: '<a href="tel:9979880383" class="text-blue-600 hover:text-blue-800 font-medium">99798 80383</a>' },
            { no: '8', hospital: 'Shraddha Eye Hospital', doctor: 'Dr. Bharg Kariya', phone: '<a href="tel:9698491000" class="text-blue-600 hover:text-blue-800 font-medium">96984 91000</a>' },
            { no: '9', hospital: 'Netradeep Maxivision Eye Hospital', doctor: 'Dr. Bhavin Tilva', phone: '<a href="tel:02812960700" class="text-blue-600 hover:text-blue-800 font-medium">0281 2960700</a><br><a href="tel:02812960600" class="text-blue-600 hover:text-blue-800 font-medium">0281 2960600</a>' },
            { no: '10', hospital: 'Ojjas Eye Hospital', doctor: 'Dr. Dipti Kanani Boda', phone: '<a href="tel:8734038922" class="text-blue-600 hover:text-blue-800 font-medium">87340 38922</a>' },
            { no: '11', hospital: 'Mehta Eye Surgery & Laser Centre', doctor: 'Dr. Pragn Mehta', phone: '<a href="tel:6352544308" class="text-blue-600 hover:text-blue-800 font-medium">63525 44308</a>' },
            { no: '12', hospital: 'Savalia Eye Hospital & Laser Centre', doctor: 'Dr. Gautam Kukadia', phone: '<a href="tel:9890558905" class="text-blue-600 hover:text-blue-800 font-medium">98905 58905</a>' }
            ]
        };

        if (selectedPlace && selectedPlace !== 'not-available') {
            const hospitals = hospitalData[selectedPlace] || [];

            if (hospitals.length > 0) {
                // Populate hospital table
                $tableBody.empty();
                hospitals.forEach(function(hospital) {
                    const row = `
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3 text-center">${hospital.no}</td>
                            <td class="border border-gray-300 px-4 py-3">${hospital.hospital}</td>
                            <td class="border border-gray-300 px-4 py-3">${hospital.doctor}</td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                ${hospital.phone}
                            </td>
                        </tr>
                    `;
                    $tableBody.append(row);
                });

                $hospitalList.removeClass('hidden').addClass('animate-fade-in');
                $notAvailableMessage.addClass('hidden');
            }
        } else if (selectedPlace === 'not-available') {
            $hospitalList.addClass('hidden');
            $notAvailableMessage.removeClass('hidden').addClass('animate-fade-in');
        } else {
            $hospitalList.addClass('hidden');
            $notAvailableMessage.addClass('hidden');
        }
    });

    // Performance Optimization: Lazy load images
    function initLazyLoading() {
        // Convert carousel images to lazy loading if intersection observer is not supported by browser
        if (!('IntersectionObserver' in window)) {
            // Fallback for older browsers - load images immediately
            $('.carousel-image[data-src]').each(function() {
                const $img = $(this);
                $img.attr('src', $img.data('src')).removeAttr('data-src');
            });
        }
    }

    // Initialize performance optimizations
    initLazyLoading();

    // Debounce function for performance
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Optimize scroll events
    const optimizedScroll = debounce(function() {
        // Add any scroll-based functionality here if needed
    }, 16); // 60fps

    $(window).on('scroll', optimizedScroll);

});
