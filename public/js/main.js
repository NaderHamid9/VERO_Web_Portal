let allTasks = [];

function fetchTasks() {
    $("#tasks-container").addClass("hidden"); // Hide table
    $("#loading-spinner").show(); // Show spinner

    $.ajax({
        url: "/tasks/update",
        method: "GET",
        success: function (data) {
            allTasks = data;
            updateTable(allTasks);
        },
        error: function () {
            console.error("Failed to fetch tasks.");
        },
        complete: function () {
            $("#loading-spinner").hide();
            $("#tasks-container").removeClass("hidden");
        },
    });
}
setInterval(fetchTasks, 3600000); //Repeat fetch every 60 minutes


function updateTable(tasks) {
    let tbody = $("#tasks-table-body");
    tbody.empty();
    tasks.forEach((item, index) => {
        let truncatedDescription =
            item.description.length > 120
                ? item.description.substring(0, 120) + "..."
                : item.description;
        let row = `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">${index + 1}</td>
                <td class="px-6 py-4">
                    <button style="background-color: ${
                        item.colorCode
                    }" class="font-medium rounded-lg text-sm px-5 py-5 me-2 mb-2"></button>
                </td>
                <td class="px-6 py-4">${item.task}</td>
                <td class="px-6 py-4">${item.title}</td>
                <td class="px-6 py-4">
                    <span class="description-short">${truncatedDescription}</span>
                    <span class="description-full hidden">${
                        item.description
                    }</span>
                    ${
                        item.description.length > 120
                            ? '<button class="toggle-description text-blue-500">more</button>'
                            : ""
                    }
                </td>
            </tr>`;
        tbody.append(row);
    });
}

function searchTasks(query) {
    query = query.toLowerCase();
    const filteredTasks = allTasks.filter(
        (item) =>
            item.task.toLowerCase().includes(query) ||
            item.title.toLowerCase().includes(query) ||
            item.description.toLowerCase().includes(query) ||
            item.colorCode.toLowerCase().includes(query)
    );
    updateTable(filteredTasks);
}

$(document).ready(function () {
    fetchTasks();
    setInterval(fetchTasks, 3600000); // Repeat fetch every 60 minutes

    $("#default-search").on("input", function () {
        const query = $(this).val();
        searchTasks(query);
    });

    $(document).on("click", ".toggle-description", function () {
        const $this = $(this);
        const $short = $this.siblings(".description-short");
        const $full = $this.siblings(".description-full");

        if ($full.hasClass("hidden")) {
            $full.removeClass("hidden");
            $short.addClass("hidden");
            $this.text("less");
        } else {
            $full.addClass("hidden");
            $short.removeClass("hidden");
            $this.text("more");
        }
    });
});

$(document).ready(function () {
    $("#image-upload").on("change", function (event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#view_area").html(
                    `<img src="${e.target.result}" alt="Uploaded Image" class="max-w-full h-auto rounded-lg">`
                );
            };
            reader.readAsDataURL(file);
        } else {
            alert("Please upload a valid image file.");
        }
    });

    $('[data-modal-hide="default-modal"]').on("click", function () {
        $("#default-modal").addClass("hidden");
    });

    // Assuming you have a button or some trigger to open the modal
    $("#open-modal-btn").on("click", function () {
        $("#default-modal").removeClass("hidden");
    });
});
