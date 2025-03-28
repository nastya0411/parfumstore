$(() => {

    let categoryCount = $('#block-props').find('.category-propscategory').length;
    
        const block = (index) => `
            <div class="border p-3 my-3 category-propscategory  col-6" data-index="${index}">
                <div class="d-flex justify-content-end">
                    <div class="btn-group" role="group" aria-label="">
                        <button type="button" class="btn btn-outline-danger btn-remove">-</button>
                        <button type="button" class="btn btn-outline-success btn-add">+</button>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="mb-3 field-categoryprop-${index}-title required">
                        <label class="form-label" for="categoryprop-${index}-title">Title</label>
                        <input type="text" id="categoryprop-${index}-title" class="form-control" name="CategoryProp[${index}]
                        [title]" maxlength="255" aria-required="true" value="text ${index}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 field-categoryprop-${index}-value required">
                        <label class="form-label" for="categoryprop-${index}-value">Value</label>
                        <input type="text" id="categoryprop-${index}-value" class="form-control" name="CategoryProp[${index}][value]" aria-required="true"
                        value="${index}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 field-categoryprop-${index}-id">
                        <input type="hidden" id="categoryprop-${index}-id" class="form-control" name="CategoryProp[${index}][id]">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
        `;
    
        $('#block-props').on('click', '.btn-add', () =>{
            categoryCount++;
            
            $('#block-props .category-propscategory:last').after(block(categoryCount))
            const title = `categoryprop-${categoryCount}-title`;

            $('#form-category').yiiActiveForm('add',


            {"id":title,"name":`[${categoryCount}]title`,"container":`.field-${title}`,
                "input":`#${title}`,"error":".invalid-feedback","validate":function 
                            (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, 
                                {"message":"Необходимо заполнить «Title»."});yii.validation.string(value, messages,
                                     {"message":"Значение «Title» должно быть строкой.","max":255,"tooLong":"Значение «Title» должно содержать максимум 255 символа."
                                        ,"skipOnEmpty":1});}});                                           
                            

                const categoryProp = `categoryprop-${categoryCount}-value`;                
                $('#form-category').yiiActiveForm('add',
                                {"id":categoryProp,
                                "name":`[${categoryCount}]value`,"container":`.field-${categoryProp}`,
                                "input":`#${categoryProp}`,"error":".invalid-feedback",
                                "validate":function (attribute, value, messages, deferred, $form)
                                 {yii.validation.required(value, messages, {"message":"Необходимо заполнить «Value»."})
                                 ;yii.validation.string(value, messages, {"message":"Значение «Value» должно быть строкой."
                                    ,"max":255,"tooLong":"Значение «Value» должно содержать максимум 255 символа.","skipOnEmpty":1});}});
        
            })
                })
        

        $('#block-props').on('click', '.btn-remove', function() {

        if ($('#block-props .category-propscategory').length > 1){
            const parent = $(this).parents('.category-propscategory')
            const index = parent.data('index')
            $('#form-category').yiiActiveForm('remove',`categoryprop-${index}-title`)
            $('#form-category').yiiActiveForm('remove',`categoryprop-${index}-value`)

            
        parent.remove();
        }
    })    