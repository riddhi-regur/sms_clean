import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import $ from "jquery";
import DataTable from "datatables.net-dt";

// Make them global so they are available in your Blade views
window.$ = window.jQuery = $;
window.DataTable = DataTable;

document.addEventListener("DOMContentLoaded", () => {
    const profileBtn = document.getElementById("profileBtn");
    const dropdown = document.getElementById("profileDropdown");

    if (profileBtn && dropdown) {
        profileBtn.addEventListener("click", () => {
            dropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", function (e) {
            if (
                !profileBtn.contains(e.target) &&
                !dropdown.contains(e.target)
            ) {
                dropdown.classList.add("hidden");
            }
        });
    }
});

$(function () {
    $("#department-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: window.routes.departmentData,
        columns: [
            { data: "name", name: "name" },
            { data: "code", name: "code" },
            { data: "description", name: "description" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
});
