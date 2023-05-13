$(document).ready(function (e) {
    let imageSvg = $('#image-preview svg');

    $('#image').change(function(e){
        let reader = new FileReader();
        reader.onload = (e) => {
            if (imageSvg.length) {
                imageSvg.replaceWith(`<img id="image-preview-element" src="${e.target.result}" alt=""/>`);
            } else {
                $("#image-preview-element").attr("src", e.target.result);
            }

        }
        reader.readAsDataURL(this.files[0]);
    });
});
