(function ($) {
    $.fn.imageUploader = function (options) {
        let defaults = {
            preloaded: [],
            imagesInputName: 'images',
            preloadedInputName: 'preloaded',
            label: ''
        };
        let plugin = this;
        plugin.settings = {};
        plugin.init = function () {
            plugin.settings = $.extend(plugin.settings, defaults, options);
            plugin.each(function (i, wrapper) {
                let $container = createContainer();
                $(wrapper).append($container);
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));
                if (plugin.settings.preloaded.length) {
                    $container.addClass('has-files');
                    let $uploadedContainer = $container.find('.uploaded');
                    for (let i = 0; i < plugin.settings.preloaded.length; i++) {
                        $uploadedContainer.find('.m-drop-row').prepend(createImg(plugin.settings.preloaded[i].src, plugin.settings.preloaded[i].id, true));
                    }
                }
            });
        };
        let dataTransfer = new DataTransfer();
        let createContainer = function () {
            let $container = $('<div>', { class: 'image-uploader' }),
                $input = $('<input>', {
                    type: 'file',
                    id: plugin.settings.imagesInputName + '-' + random(),
                    name: plugin.settings.imagesInputName + '[]',
                    multiple: '',
                    accept: "image/*"
                }).appendTo($container),
                $uploadedContainer = $('<div>', { class: 'uploaded' }).appendTo($container),
                $row = $('<div>', { class: 'm-drop-row' }).appendTo($uploadedContainer);
            $textContainer = $('<div>', {
                class: 'new-uploader m-drop-col'
            }).appendTo($row),
                $span = $('<img style="height:80px;" src="https://pixsector.com/cache/517d8be6/av5c8336583e291842624.png" alt="">').appendTo($textContainer);
            $container.on('click', function (e) {
                prevent(e);
                $input.trigger('click');
            });
            $input.on("click", function (e) {
                e.stopPropagation();
            });
            $input.on('change', fileSelectHandler.bind($container));
            return $container;
        };


        let prevent = function (e) {
            e.preventDefault();
            e.stopPropagation();
        };

        let createImg = function (src, id) {
            let $container = $('<div>', { class: 'uploaded-image m-drop-col' }),
                $img = $('<img>', { src: src }).appendTo($container),
                $button = $('<button>', { class: 'delete-image' }).appendTo($container),
                $i = $('<i>', { class: 'fa fa-times', text: '' }).appendTo($button);
            if (plugin.settings.preloaded.length) {
                $container.attr('data-preloaded', true);
                let $preloaded = $('<input>', {
                    type: 'hidden',
                    name: plugin.settings.preloadedInputName + '[]',
                    value: id
                }).prependTo($container)
            } else {
                $container.attr('data-index', id);
            }
            $container.on("click", function (e) {
                prevent(e);
            });
            $button.on("click", function (e) {
                prevent(e);
                if ($container.data('index')) {
                    let index = parseInt($container.data('index'));
                    $container.find('.uploaded-image[data-index]').each(function (i, cont) {
                        if (i > index) {
                            $(cont).attr('data-index', i - 1);
                        }
                    });
                    dataTransfer.items.remove(index);
                }
                $container.remove();
                if (!$container.find('.uploaded-image').length) {
                    $container.removeClass('has-files');
                }
            });
            return $container;
        };

        let fileDragHover = function (e) {
            prevent(e);
            if (e.type === "dragover") {
                $(this).addClass('drag-over');
            } else {
                $(this).removeClass('drag-over');
            }
        };

        let allowedExtensions = ["image/jpeg", "image/png", "image/gif", "image/webp", "image/bmp"];

        let fileSelectHandler = function (e) {
            prevent(e);
            let $container = $(this);
            $container.removeClass('drag-over');
            let files = e.target.files || e.originalEvent.dataTransfer.files;

            // Validate each file
            let validFiles = [];
            $(files).each(function (i, file) {
                if (!allowedExtensions.includes(file.type)) {
                    $.confirm({
                        title: 'Upload image',
                        content: 'Only WebP,png,jpeg,gif,bmp files are allowed.',
                        buttons: {
                            cancel: {
                                text: 'Cancel',
                                action: function () { }
                            }
                        }
                    });
                } else {
                    validFiles.push(file);
                }
            });

            if (validFiles.length > 0) {
                setPreview($container, validFiles);
            }
        };

        let setPreview = function ($container, files) {
            $container.addClass('has-files');
            let $uploadedContainer = $container.find('.uploaded'),
                $input = $container.find('input[type="file"]');

            $(files).each(function (i, file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    let img = new Image();
                    img.onload = function () {
                            dataTransfer.items.add(file);
                            $uploadedContainer.find(".m-drop-row").prepend(createImg(URL.createObjectURL(file), dataTransfer.items.length - 1));
                            $input.prop('files', dataTransfer.files);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });

        };

        let random = function () {
            return Date.now() + Math.floor((Math.random() * 100) + 1);
        };
        this.init();
        return this;
    };

}(jQuery));
