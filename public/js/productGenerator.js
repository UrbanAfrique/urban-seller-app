const productGenerator = {
    preloadedHolder: $("#preloaded"),
    variantHolder: $(".variantHolder"),
    optionHolder: $(".optionsHolder"),
    priceHolder: $(".price_holder"),
    firstOption: $("#option_value_0"),
    secondOption: $("#option_value_1"),
    thirdOption: $("#option_value_2"),
    multiDropifyHolder: $(".mdropify"),
    multiSelectHolder: $('.multi-select'),
    options: [],
    currentTotalOptions: 1,
    type: 'app',
    updateProductStatus: function (cElement, route) {
        let status = $(cElement).closest('td').find('select').find('option:selected').val();
        console.log(status);
        $.confirm({
            title: 'Product Status',
            content: 'Really wants to change the status to ' + status + '?',
            buttons: {
                confirm: {
                    text: 'update',
                    action: function () {
                        productGenerator.showWait();
                        $.ajax({
                            url: route,
                            type: 'POST',
                            data: {
                                'status': status
                            },
                            success: function (response) {
                                productGenerator.hideWait();
                                if (response.success === true) {
                                    productGenerator.showSuccess(response.message);
                                } else {
                                    productGenerator.showSuccess(response.message);
                                }
                            },
                            error: function (error) {
                                productGenerator.showError("Some thing went wrong");
                            }
                        });
                    }
                },
                cancel: {}
            }
        });
    },
    manageVendorApproval: function (cElement, route, vendor_id, type) {
        if (type === 'rejected') {
            $.confirm({
                title: 'Reject Reason',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<textarea type="text" placeholder="Enter Reason" class="reject_reason form-control fs-13px"></textarea>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Reject',
                        action: function () {
                            let reject_reason = this.$content.find('.reject_reason').val();
                            if (!reject_reason) {
                                $.alert('First Enter the Reason');
                                return false;
                            } else {
                                $.confirm({
                                    content: function () {
                                        const self = this;
                                        productGenerator.showWait();
                                        return $.ajax({
                                            url: route,
                                            type: 'POST',
                                            data: {
                                                'vendor_id': vendor_id,
                                                'approved': type,
                                                'reject_reason': reject_reason
                                            },
                                        }).done(function (response) {
                                            productGenerator.hideWait();
                                            $(cElement).closest('tr').find("#approved_holder").empty().html(response.approved);
                                            $(cElement).closest('tr').find("#action_holder").empty().html(response.action);
                                            $(".jconfirm-buttons").find('button:first-of-type').click();
                                            productGenerator.showSuccess("Successfully Rejected");
                                        }).fail(function () {
                                            productGenerator.showError('Something went wrong.');
                                        });
                                    }
                                });
                            }
                        }
                    },
                    cancel: function () {
                        //close
                    },
                }
            });
        } else {
            $.confirm({
                title: 'Approved',
                content: 'Are you sure?',
                buttons: {
                    confirm: {
                        text: 'approve',
                        action: function () {
                            productGenerator.showWait();
                            $.ajax({
                                url: route,
                                type: 'POST',
                                data: {
                                    'vendor_id': vendor_id,
                                    'approved': type,
                                },
                                success: function (response) {
                                    productGenerator.hideWait();
                                    $(cElement).closest('tr').find("#approved_holder").empty().html(response.approved);
                                    $(cElement).closest('tr').find("#action_holder").empty().html(response.action);
                                    $(".jconfirm-buttons").find('button:first-of-type').click();
                                    productGenerator.showSuccess("Approved Successfully");
                                },
                                error: function (error) {
                                    productGenerator.showError(error);
                                }
                            });
                        }
                    },
                    cancel: {}
                }
            });
        }
    },
    deleteProduct: function (cElement, route) {
        $.confirm({
            title: 'Delete Product',
            content: 'Are you sure you want to delete this Product?',
            buttons: {
                confirm: {
                    text: 'delete',
                    action: function () {
                        productGenerator.showWait();
                        $.ajax({
                            url: route,
                            type: 'GET',
                            success: function (response) {
                                productGenerator.hideWait();
                                if (response.success === true) {
                                    $(cElement).closest('tr').css('background-color', 'red').fadeOut('30000');
                                    productGenerator.showSuccess(response.message);
                                } else {
                                    productGenerator.showError(response.message);
                                }
                            },
                            error: function (error) {
                                productGenerator.showError("Some thing went wrong");
                            }
                        });
                    }
                },
                cancel: {}
            }
        });
    },
    manageProductApproval: function (cElement, route, product_id, type) {
        if (type === 'rejected') {
            $.confirm({
                title: 'Reject Reason',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<textarea type="text" placeholder="Enter Reason" class="reject_reason form-control fs-13px"></textarea>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Reject',
                        action: function () {
                            let reject_reason = this.$content.find('.reject_reason').val();
                            if (!reject_reason) {
                                $.alert('First Enter the Reason');
                                return false;
                            } else {
                                $.confirm({
                                    content: function () {
                                        const self = this;
                                        productGenerator.showWait();
                                        return $.ajax({
                                            url: route,
                                            type: 'POST',
                                            data: {
                                                'product_id': product_id,
                                                'approved': type,
                                                'reject_reason': reject_reason
                                            },
                                        }).done(function (response) {
                                            productGenerator.hideWait();
                                            let cRow = $("#current_product_" + product_id);
                                            cRow.find("#approved_holder").empty().html(response.approved);
                                            cRow.find("#action_holder").empty().html(response.action);
                                            $(".jconfirm-buttons").find('button:first-of-type').click();
                                            productGenerator.showSuccess("Project Rejected Successfully");
                                        }).fail(function () {
                                            productGenerator.showError('Something went wrong.');
                                        });
                                    }
                                });
                            }
                        }
                    },
                    cancel: function () {
                        //close
                    },
                }
            });
        } else {
            $.confirm({
                title: 'Approved',
                content: 'Are you sure?',
                buttons: {
                    confirm: {
                        text: 'approve',
                        action: function () {
                            productGenerator.showWait();
                            $.ajax({
                                url: route,
                                type: 'POST',
                                data: {
                                    'product_id': product_id,
                                    'approved': type,
                                },
                                success: function (response) {
                                    productGenerator.hideWait();
                                    let cRow = $("#current_product_" + product_id);
                                    cRow.find("#approved_holder").empty().html(response.approved);
                                    cRow.find("#action_holder").empty().html(response.action);
                                    $(".jconfirm-buttons").find('button:first-of-type').click();
                                    productGenerator.showSuccess("Product Approved Successfully");
                                },
                                error: function (error) {
                                    productGenerator.showError(error);
                                }
                            });
                        }
                    },
                    cancel: {}
                }
            });
        }
        productGenerator.managePopover();
    },
    managePopover: function () {
        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        let popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, { html: true });
        });
    },
    addOption: function () {
        const optionStyle = productGenerator.type === 'app' ? 'border p-1' : 'w3-border w3-padding';
        const inputClass = productGenerator.type === 'app' ? 'form-control form-control-sm' : 'w3-input w3-border w3-padding-bottom';
        const labelClass = productGenerator.type === 'app' ? 'form-label' : 'w3-padding-bottom';
        const html = `
        <div style="position: relative;" id="currentParent_${productGenerator.currentTotalOptions}" class="innerOption ${optionStyle}">
            <a class="remove-box" onclick="productGenerator.removeOption(${productGenerator.currentTotalOptions})">x</a>
            <label class="${labelClass}">Option Name</label>
            <input name="options[]" class="${inputClass}" style="padding-left: 10px;" name="option[${productGenerator.currentTotalOptions}]">
            <div class="${productGenerator.type === 'app' ? 'my-2' : 'w3-margin-bottom w3-margin-top'} cOptionValue">
                <label class="${labelClass}">Option Values</label>
                <input type="text" class="${inputClass} tagify tagi-${productGenerator.currentTotalOptions}" placeholder="Enter Comma Values.." data-id="${productGenerator.currentTotalOptions}">
            </div>
        </div>`;
        this.priceHolder.hide();
        if (this.currentTotalOptions < 4) {
            this.optionHolder.append(html);
            let currentParentId = "#currentParent_" + productGenerator.currentTotalOptions;
            console.log(currentParentId);
            let tagifyElement = $(currentParentId).find(".tagify")[0];
            let tagify = new Tagify(tagifyElement);
            tagify.on('add', function (e) {
                let values = e.detail.tagify.value;
                let target_opt = $(e.detail.tagify.DOM.originalInput).data('id');
                productGenerator.options[target_opt] = [];
                if (values.length > 0) {
                    for (const key in values) {
                        productGenerator.options[target_opt].push(values[key]['value']);
                    }
                }
                productGenerator.makeSubsets();
            });
            tagify.on('remove', function (e) {
                let elementId = $(e.detail.tagify.DOM.originalInput).data('id');
                let tagToRemove = e.detail.data.value;
                let tagElements = productGenerator.options[elementId];
                productGenerator.options[elementId] = tagElements.filter(item => item !== tagToRemove);
                productGenerator.delVariantsOnTagDelete(tagToRemove);
            });
            productGenerator.currentTotalOptions++;
        } else {
            productGenerator.showError("Only 3 Options are Allowed");
        }
    },
    removeOption: function (optionId) {
        let elementId = "#currentParent_" + optionId;
        this.options[optionId] = undefined;
        this.currentTotalOptions--;
        if (this.currentTotalOptions > 0) {
            productGenerator.makeSubsets();
        } else {
            this.variantHolder.empty();
            this.priceHolder.show();
        }
        $(elementId).remove();
    },
    delVariantsOnTagDelete: function (tagToRemove) {
        const variants = this.variantHolder.find("input[name='variants[name][]");
        variants.each(function (i, element) {
            let cElement = $(element);
            const currentTitle = cElement.val();
            if (currentTitle.includes(tagToRemove)) {
                cElement.closest('tr').remove();
            }
        });
    },
    makeSubsets: function () {
        const option1 = this.options[0];
        const option2 = this.options[1];
        const option3 = this.options[2];
        const uniqueVariants = new Set();
        if (option1 !== undefined && option2 !== undefined && option3 !== undefined) {
            for (const op1 of option1) {
                for (const op2 of option2) {
                    for (const op3 of option3) {
                        uniqueVariants.add(op1 + '/' + op2 + "/" + op3);
                    }
                }
            }
        } else if (option1 !== undefined && option2 !== undefined && option3 === undefined) {
            for (const op1 of option1) {
                for (const op2 of option2) {
                    uniqueVariants.add(op1 + '/' + op2);
                }
            }
        } else if (option1 !== undefined && option2 === undefined && option3 === undefined) {
            for (const op1 of option1) {
                uniqueVariants.add(op1);
            }
        }
        const variants = Array.from(uniqueVariants);
        productGenerator.updateVariantTitles();
        productGenerator.appendUniqueVariants(variants);
    },
    updateVariantTitles: function () {
        const variants = this.variantHolder.find("input[name='variants[name][]");
        variants.each(function () {
            const currentVariant = $(this);
            const currentTitle = currentVariant.val();
            const newTitleParts = currentTitle.split("/");
            productGenerator.options.forEach(function (optionValues, optionIndex) {
                if (!newTitleParts[optionIndex] || !optionValues.includes(newTitleParts[optionIndex])) {
                    newTitleParts[optionIndex] = optionValues[0];
                }
            });
            const newTitle = newTitleParts.join("/");
            currentVariant.val(newTitle);
        });
    },
    appendUniqueVariants: function (newVariants) {
        let tableClass = "w3-table-all";
        let responsiveClass = 'w3-responsive';
        let inputClass = "w3-input w3-border w-100px";
        if (productGenerator.type === 'app') {
            tableClass = "table table-bordered w-100 table-striped";
            responsiveClass = 'table-responsive';
            inputClass = "form-control form-control-sm w-100px";
        }
        const existingVariants = this.variantHolder.find("input[name='variants[name][]");
        const existingVariantValues = existingVariants.map(function (index, element) {
            return $(element).val();
        }).get();
        const existingVariantTable = this.variantHolder.find('table');
        let html = "";
        if (existingVariantTable.length === 0) {
            html = "<div class='" + responsiveClass + "'><table class='" + tableClass + "'>" + '<thead><tr>' + '<th>Title</th>' + '<th>Sku</th>' + '<th>Price</th>' + '<th>Comp at Price</th>' + '<th>Quantity</th>' + '<th>BarCode</th>' + '<th>Weight</th>' + '</tr></thead><tbody></tbody></table></div>';
            this.variantHolder.append(html);
        }
        newVariants.forEach(function (variant) {
            if (!existingVariantValues.includes(variant)) {
                let variant_html = `
            <tr>
                <td><input value="${variant}" name="variants[name][]" class="${inputClass}"></td>
                <td><input type="text" class="${inputClass}" name="variants[sku][]" required="required"></td>
                <td><input type="text" class="${inputClass}" name="variants[price][]" step="0.01" required="required"></td>
                <td><input type="text" class="${inputClass}" name="variants[compare_at_price][]" step="0.01"></td>
                <td><input type="number" class="${inputClass}" name="variants[inventory_quantity][]" step="0.01" required="required"></td>
                <td><input type="text" class="${inputClass}" name="variants[barcode][]"></td>
                <td><input type="text" class="${inputClass}" name="variants[weight][]"></td>
            </tr>`;
                productGenerator.variantHolder.find('tbody').append(variant_html);
            }
        });
    },
    showWait: function () {
        Swal.fire({
            customClass: {
                confirmButton: 'd-none', cancelButton: 'd-none',
            },
            html: 'Please wait...Processing Request!',
            allowOutsideClick: () => !Swal.isLoading(),
            allowEscapeKey: () => !Swal.isLoading(),
            allowEnterKey: () => !Swal.isLoading()
        });
        Swal.showLoading();
    },
    hideWait: function () {
        Swal.close();
    },
    showError: function (msg) {
        $.toast({
            heading: 'Error', text: msg, position: 'top-right', icon: 'error'
        })
    },
    showSuccess: function (msg) {
        $.toast({
            heading: 'Success', text: msg, position: 'top-right', icon: 'success'
        })
    },
    applyExistingTagify: function () {
        productGenerator.multiSelectHolder.multipleSelect()
        new Tagify($(".tags")[0]);
        if (productGenerator.firstOption && productGenerator.firstOption.val()) {
            productGenerator.options[0] = productGenerator.firstOption.val().split(",").map(value => value.trim());
        }
        if (productGenerator.secondOption && productGenerator.secondOption.val()) {
            productGenerator.options[1] = productGenerator.secondOption.val().split(",").map(value => value.trim());
        }
        if (productGenerator.thirdOption && productGenerator.thirdOption.val()) {
            productGenerator.options[2] = productGenerator.thirdOption.val().split(",").map(value => value.trim());
        }
        let firstTagify = new Tagify(productGenerator.firstOption[0]);
        firstTagify.on('add', function (e) {
            let values = e.detail.tagify.value;
            let target_opt = $(e.detail.tagify.DOM.originalInput).data('id');
            productGenerator.options[target_opt] = [];
            if (values.length > 0) {
                for (const key in values) {
                    productGenerator.options[target_opt].push(values[key]['value']);
                }
            }
            productGenerator.makeSubsets();
        });
        firstTagify.on('remove', function (e) {
            let elementId = $(e.detail.tagify.DOM.originalInput).data('id');
            let tagToRemove = e.detail.data.value;
            let tagElements = productGenerator.options[elementId];
            productGenerator.options[elementId] = tagElements.filter(item => item !== tagToRemove);
            productGenerator.delVariantsOnTagDelete(tagToRemove);
        });
        let secondTagify = new Tagify(productGenerator.secondOption[0]);
        secondTagify.on('add', function (e) {
            let values = e.detail.tagify.value;
            let target_opt = $(e.detail.tagify.DOM.originalInput).data('id');
            productGenerator.options[target_opt] = [];
            if (values.length > 0) {
                for (const key in values) {
                    productGenerator.options[target_opt].push(values[key]['value']);
                }
            }
            productGenerator.makeSubsets();
        });
        secondTagify.on('remove', function (e) {
            let elementId = $(e.detail.tagify.DOM.originalInput).data('id');
            let tagToRemove = e.detail.data.value;
            let tagElements = productGenerator.options[elementId];
            productGenerator.options[elementId] = tagElements.filter(item => item !== tagToRemove);
            productGenerator.delVariantsOnTagDelete(tagToRemove);
        });
        let thirdTagify = new Tagify(productGenerator.thirdOption[0]);
        thirdTagify.on('add', function (e) {
            let values = e.detail.tagify.value;
            let target_opt = $(e.detail.tagify.DOM.originalInput).data('id');
            productGenerator.options[target_opt] = [];
            if (values.length > 0) {
                for (const key in values) {
                    productGenerator.options[target_opt].push(values[key]['value']);
                }
            }
            productGenerator.makeSubsets();
        });
        thirdTagify.on('remove', function (e) {
            let elementId = $(e.detail.tagify.DOM.originalInput).data('id');
            let tagToRemove = e.detail.data.value;
            let tagElements = productGenerator.options[elementId];
            productGenerator.options[elementId] = tagElements.filter(item => item !== tagToRemove);
            productGenerator.delVariantsOnTagDelete(tagToRemove);
        });
    },
    initialImageLoader: function () {
        const value = this.preloadedHolder.val();
        const preloaded = value !== "" && value !== undefined ? JSON.parse(value) : {};
        productGenerator.multiDropifyHolder.imageUploader({
            imagesInputName: 'mFiles',
            preloaded: preloaded,
            preloadedInputName: 'oldFiles',
            Size: 2 * 1024 * 1024
        });
    },
    createOrUpdateProxyVendor: function (cElement, type = 'create') {
    let cForm = $(cElement);
    let url = cForm.attr('action').replace('http://', 'https://');
    let formData = new FormData(cForm[0]);
    productGenerator.showWait();
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
            success: function (result) {
                productGenerator.hideWait();
                if (result.success === true) {
                    console.log(result);
                    if (type === 'create') {
                        productGenerator.showSuccess("Vendor Created Successfully");
                        // $("#customer_login_email").val($("#email").val());
                        // $("#customer_login_password").val($("#password").val());
                        // $("#customer_login")[0].submit();
                        if (cForm.find('btn-seller-reg').length) {
                            cForm.find('btn-seller-reg').val('redirecting...').prop('disabled', true);
                        }
                        location.assign('/log-in-page-for-sellers?return_url=/a/seller');
                    } else {
                        productGenerator.showSuccess("Vendor Updated Successfully");
                    }
                } else {
                    console.log(result.errors);
                    $.each(result.errors, function (key, value) {
                        if (key === 'email') {
                            value = 'Email has already been taken'
                        }
                        productGenerator.showError(value);
                    });
                }
            },
            error: function (xhr, status, error) {
                productGenerator.hideWait();
                console.log(xhr.status);
                console.log(xhr.responseJSON);
            }
        });

        // }
        return false;
    },
    createOrUpdateProduct: function (type, method) {
        let cForm = $("#productForm");
        let url = cForm.attr('action');
        let formData = new FormData(cForm[0]);
        let tags = $("#tags").val();
        let body_html = $('#body_html').summernote('code');
        if (tags === '') {
            productGenerator.showError("Please Enter atleast one Tag");
        } else if (body_html === '') {
            productGenerator.showError("Product Description is Required");
        } else {

            tags = JSON.parse(tags).map(function (item) {
                return item.value;
            }).join(',');

            formData.set('tags', tags)
            formData.set('body_html', body_html);
            productGenerator.showWait();
            $.ajax({
                type: method,
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    productGenerator.hideWait();
                    if (result.success === true) {
                        productGenerator.showSuccess(result.successMessage);
                        productGenerator.preloadedHolder.val(JSON.stringify(result.product.images));
                        if (type === 'create') {
                            setTimeout(function () {
                                const redirectUrl = '/a/seller/products/' + result.product.id + "/edit";
                                location.assign(redirectUrl);
                            }, 3000);
                        }
                    } else if (result.success === false) {
                        result.errors.forEach(function (error) {
                            productGenerator.showError(error);
                        });
                    } else {
                        productGenerator.showError("Some thing is wrong...");
                    }
                },
                error: function (error) {
                    productGenerator.hideWait();
                    productGenerator.showError(error)
                }
            });
        }
        return false;
    },
    updateCurrentTotal: function () {
        const length = $(".innerOption").length;
        if (length !== null && length !== undefined && length !== '' && !isNaN(length)) {
            productGenerator.currentTotalOptions = length;
        }
    },
    applyFulFillment: function () {

        console.log("apply Fulfillment");
        let fulfillment_form = $("#fulfillment_form");
        let selectedItems = $('.w3-check:checked');
        let tracking_number = $('#tracking_number');
        let shipping_career = $('#shipping_career');

        console.log(selectedItems.length);
        if (selectedItems.length === 0) {
            this.showError("At Least Select One Item");
        } else if (tracking_number.val() === '' || shipping_career.val() === '') {
            this.showError("Tracking Number and Shipping Career is required");
            if (tracking_number.val() === '') {
                tracking_number.focus();
            } else if (shipping_career.val() === '') {
                shipping_career.focus();
            }
        } else {
            let formData = fulfillment_form.serialize();
            productGenerator.showWait();
            $.ajax({
                type: 'POST',
                url: fulfillment_form.attr('href'),
                data: formData,
                success: function (data) {
                    if (data.success === true) {
                        productGenerator.hideWait();
                        productGenerator.showSuccess("Successfully Fulfilled Line Items");
                        setTimeout(function () {
                            location.assign('/a/seller/orders');
                        }, 3000);
                    }
                },
                error: function (error) {
                    productGenerator.hideWait();
                    productGenerator.showError('There was a problem with the AJAX request:', error);
                }
            });
        }
    },
    addPayout: function (e) {
        e.preventDefault();
        let type = $('.payout_type:checked').val();
        let paypal = $('#paypal_id');
        let payout_form = $('#payout_form');
        console.log("apply payout", type);

        if (type == undefined)
            this.showError("Select payout type");
        else if (paypal.val() === '' && type == 'paypal') {
            this.showError("Add your paypal account id");
            paypal.focus();
        } else {
            let formData = payout_form.serialize();
            productGenerator.showWait();
            $.ajax({
                type: 'POST',
                url: payout_form.attr('href'),
                data: formData,
                success: function (data) {
                    if (data.success === true) {
                        // productGenerator.hideWait();
                        productGenerator.showSuccess("Payout successfully added.");
                        // setTimeout(function () {
                            location.reload();
                        // }, 3000);
                    }
                },
                error: function (error) {
                    productGenerator.showError('There was a problem with the AJAX request:', error);
                }
            });
        }
        return false;
    },
    withdraw: function () {

        var amount = $('#withdraw_amt').val();
        var balance = $('#withdraw_amt').attr('max');
        console.log(amount, balance, amount > balance, parseFloat(amount) > parseFloat(balance));
        if(parseFloat(amount) > parseFloat(balance)){
            productGenerator.showError("Requested amount more than balance");
            return false;
        }


        let withdraw_form = $('#withdraw_form');
        let formData = withdraw_form.serialize();
        productGenerator.showWait();
        $.ajax({
            type: 'POST',
            url: withdraw_form.attr('href'),
            data: formData,
            success: function (data) {
                productGenerator.hideWait();
                if (data.success === true) {
                    productGenerator.showSuccess("Withdraw requested successfully.");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    productGenerator.showError(data.message);
                }
            },
            error: function (error) {
                productGenerator.hideWait();
                productGenerator.showError('There was a problem with the AJAX request:', error);
            }
        });

    },

    payoutReset: function (e) {
        console.log('route', $(e).attr('data-href'));
        $.confirm({
            title: 'Confirm',
            content: 'Are you sure you want to reset payout method?',
            buttons: {
                confirm: {
                    text: 'reset',
                    action: function () {
                        productGenerator.showWait();
                        $.ajax({
                            url: $(e).attr('data-href'),
                            type: 'POST',
                            data: {vendor_id: $(e).attr('data-vendor')},
                            success: function (response) {
                                // productGenerator.hideWait();
                                if (response.success === true) {
                                    productGenerator.showSuccess(response.message);
                                    location.reload();
                                } else {
                                    productGenerator.showError(response.message);
                                }
                            },
                            error: function (error) {
                                productGenerator.showError("Some thing went wrong");
                            }
                        });
                    }
                },
                cancel: {}
            }
        });
    },
    deleteVendor: function (cElement, route) {
        $.confirm({
            title: 'Delete Vendor',
            content: 'Are you sure you want to delete?',
            buttons: {
                confirm: {
                    text: 'delete',
                    action: function () {
                        productGenerator.showWait();
                        $.ajax({
                            url: route,
                            type: 'DELETE',
                            success: function (response) {
                                productGenerator.hideWait();
                                if (response.success === true) {
                                    $(cElement).closest('tr').css('background-color', 'red').fadeOut('30000');
                                    productGenerator.showSuccess(response.message);
                                } else {
                                    productGenerator.showError(response.message);
                                }
                            },
                            error: function (error) {
                                productGenerator.showError("Some thing went wrong");
                            }
                        });
                    }
                },
                cancel: {}
            }
        });
    },
    setAjaxHeader: function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
}
$(document).ready(function () {
    console.log("page is loaded");
    let currentUrl = window.location.href;
    if (currentUrl.indexOf("/a/seller/") !== -1) {
        productGenerator.type = 'proxy';
    } else {
        productGenerator.type = 'app';
    }
    $('.menu-links a:not(.w3-btn)').click(function () {
        productGenerator.showWait();
    });
    productGenerator.updateCurrentTotal();
    productGenerator.applyExistingTagify();
    productGenerator.initialImageLoader();
    //customer tagify
    if ($(".customerTagify").length) {
        new Tagify($(".customerTagify")[0]);
        $('.editor').summernote({
            placeholder: 'Start writing here...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    }
});
