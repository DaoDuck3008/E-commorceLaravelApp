// Preview ảnh mới được chọn
document.getElementById("file").addEventListener("change", function (event) {
    let preview = document.getElementById("preview");
    preview.innerHTML = ""; // clear trước khi chọn lại

    if (event.target.files.length > 0) {
        let label = document.createElement("div");
        label.innerHTML = '<h6 class="mb-3 text-primary">Preview ảnh mới:</h6>';
        preview.appendChild(label);
    }

    Array.from(event.target.files).forEach((file, index) => {
        let reader = new FileReader();
        reader.onload = function (e) {
            let col = document.createElement("div");
            col.classList.add("col-3", "mb-3");

            col.innerHTML = `
                <div class="card shadow-sm image-card">
                    <img src="${e.target.result}" class="card-img-top image-preview">
                    <div class="card-body p-2">
                        <small class="text-muted">${file.name}</small>
                    </div>
                </div>
            `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
});

// Xử lý checkbox xóa ảnh
document.addEventListener("DOMContentLoaded", function () {
    const deleteCheckboxes = document.querySelectorAll(
        'input[name="delete_images[]"]'
    );

    deleteCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            const imageCard = this.closest(".card");
            const img = imageCard.querySelector("img");

            if (this.checked) {
                imageCard.style.opacity = "0.5";
                img.style.filter = "grayscale(100%)";
                imageCard.style.border = "2px solid #dc3545";
            } else {
                imageCard.style.opacity = "1";
                img.style.filter = "none";
                imageCard.style.border = "none";
            }
        });
    });
});

// Xác nhận trước khi submit form
document.querySelector("form").addEventListener("submit", function (e) {
    const deletedImages = document.querySelectorAll(
        'input[name="delete_images[]"]:checked'
    );
    if (deletedImages.length > 0) {
        if (
            !confirm(
                `Bạn có chắc chắn muốn xóa ${deletedImages.length} hình ảnh được chọn?`
            )
        ) {
            e.preventDefault();
        }
    }
});

// Hàm thêm row vào thông số kỹ thuật
let specIndex = 3;
function addSpecRow() {
    let table = document.getElementById("spec-table");
    let row = document.createElement("tr");
    row.innerHTML = `
  <td><input type="text" class="form-control" name="spec[${specIndex}][key]" placeholder="Tên thông số"></td>
  <td><input type="text" class="form-control" name="spec[${specIndex}][value]" placeholder="Nội dung thông số"></td>
`;
    table.appendChild(row);

    specIndex++;
}

// Hàm thêm row vào phiên bản sản phẩm
let versionIndex = 1;
function addVersionRow() {
    let table = document.getElementById("version-table");
    let row = document.createElement("tr");
    row.innerHTML = `
  <td><input type="text" class="form-control" name="version[${versionIndex}][name]" placeholder="Tên phiên bản"></td>
  <td><input type="number" class="form-control" name="version[${versionIndex}][price]" placeholder="Giá phiên bản"></td>
`;
    table.appendChild(row);
    versionIndex++;
}

// Hàm thêm row vào màu sắc sản phẩm
let colorIndex = 2;
function addColorRow() {
    let table = document.getElementById("color-table");
    let row = document.createElement("tr");
    row.innerHTML = `
  <td><input type="text" class="form-control" name="color[${colorIndex}][name]" placeholder="Tên màu"></td>
  <td class="d-flex">
    <input type="file" class="form-control w-50" accept="image/*" name="color[${colorIndex}][image]" onchange="previewColorImage(this, ${colorIndex})">
    <div id="color-preview-${colorIndex}" class="mt-1 ms-1"></div>
  </td>
`;
    table.appendChild(row);
    colorIndex++;
}

// Hàm preview ảnh cho màu sắc
function previewColorImage(input, index) {
    let preview = document.getElementById("color-preview-" + index);
    preview.innerHTML = "";

    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
            `;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
