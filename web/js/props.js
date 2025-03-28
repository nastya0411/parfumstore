$(() => {

let notesCount = $('#block-props').find('.notes-props').length;

    const block = (index) => `
        <div class="border p-3 my-3 notes-props col-6" data-index="${index}">
            <div class="d-flex justify-content-end">
                <div class="btn-group" role="group" aria-label="">
                    <button type="button" class="btn btn-outline-danger btn-remove">-</button>
                    <button type="button" class="btn btn-outline-success btn-add">+</button>
                </div>
            </div>
            <div class="d-flex gap-3">
                <div class="mb-3 field-notesprop-${index}-title required">
                    <label class="form-label" for="notesprop-${index}-title">Title</label>
                    <input type="text" id="notesprop-${index}-title" class="form-control" name="NotesProp[${index}]
                    [title]" maxlength="255" aria-required="true" value="text ${index}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3 field-notesprop-${index}-value required">
                    <label class="form-label" for="notesprop-${index}-value">Value</label>
                    <input type="text" id="notesprop-${index}-value" class="form-control" name="NotesProp[${index}][value]" aria-required="true"
                    value="${index}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3 field-notesprop-${index}-id">
                    <input type="hidden" id="notesprop-${index}-id" class="form-control" name="NotesProp[${index}][id]">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    `;

    $('#block-props').on('click', '.btn-add', () =>{
        notesCount++;
        $('#block-props .notes-props:last').after(block(notesCount))
        
        const title = `notesprop-${notesCount}-title`;

        $('#form-notes').yiiActiveForm('add',
        {"id":title,"name":`[${notesCount}]title`,"container":`.field-${title}`,
            "input":`#${title}`,"error":".invalid-feedback","validate":function 
            (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, 
                {"message":"Необходимо заполнить «Title»."});yii.validation.string(value, messages,
                     {"message":"Значение «Title» должно быть строкой.","max":255,"tooLong":"Значение «Title» должно содержать максимум 255 символа."
                        ,"skipOnEmpty":1});}});


        const notesProp = `notesprop-${notesCount}-value`;                
        $('#form-notes').yiiActiveForm('add',
                        {"id":notesProp,
                        "name":`[${notesCount}]value`,"container":`.field-${notesProp}`,
                        "input":`#${notesProp}`,"error":".invalid-feedback",
                        "validate":function (attribute, value, messages, deferred, $form)
                         {yii.validation.required(value, messages, {"message":"Необходимо заполнить «Value»."})
                         ;yii.validation.string(value, messages, {"message":"Значение «Value» должно быть строкой."
                            ,"max":255,"tooLong":"Значение «Value» должно содержать максимум 255 символа.","skipOnEmpty":1});}});

    })

    $('#block-props').on('click', '.btn-remove', function() {

        if ($('#block-props .notes-props').length > 1){
            const parent = $(this).parents('.notes-props')
            const index = parent.data('index')
            $('#form-notes').yiiActiveForm('remove',`notesprop-${index}-title`)
            $('#form-notes').yiiActiveForm('remove',`notesprop-${index}-value`)

            
        parent.remove();
        }
    })
})