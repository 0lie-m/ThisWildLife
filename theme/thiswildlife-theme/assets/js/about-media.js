document.addEventListener("DOMContentLoaded", function () {
  const selectors = document.querySelectorAll(
    ".twl-media-selector"
  );

  selectors.forEach(function (selector) {
    const idsInput = selector.querySelector(
      ".twl-media-ids"
    );

    const managedInput = selector.querySelector(
      ".twl-media-managed"
    );

    const preview = selector.querySelector(
      ".twl-media-preview"
    );

    const selectButton = selector.querySelector(
      ".twl-select-media"
    );

    const clearButton = selector.querySelector(
      ".twl-clear-media"
    );

    const multiple =
      selector.dataset.multiple === "true";

    if (
      !idsInput ||
      !managedInput ||
      !preview ||
      !selectButton ||
      !clearButton
    ) {
      return;
    }

    const getSelectedIds = function () {
      return idsInput.value
        .split(",")
        .map(function (id) {
          return Number.parseInt(id, 10);
        })
        .filter(function (id) {
          return Number.isInteger(id) && id > 0;
        });
    };

    const syncIdsFromPreview = function () {
      const ids = Array.from(
        preview.querySelectorAll(".twl-media-item")
      ).map(function (item) {
        return item.dataset.attachmentId;
      });

      idsInput.value = multiple
        ? ids.join(",")
        : ids[0] || "";

      managedInput.value = "1";
    };

    const createPreviewItem = function (attachment) {
      const item = document.createElement("div");
      item.className = "twl-media-item";
      item.dataset.attachmentId = attachment.id;

      const image = document.createElement("img");

      const thumbnail =
        attachment.sizes &&
        attachment.sizes.thumbnail
          ? attachment.sizes.thumbnail.url
          : attachment.url;

      image.src = thumbnail;
      image.alt =
        attachment.alt ||
        attachment.title ||
        "";

      image.style.display = "block";
      image.style.height = "100px";
      image.style.objectFit = "cover";
      image.style.width = "100px";

      const removeButton =
        document.createElement("button");

      removeButton.className =
        "button-link-delete twl-remove-media";

      removeButton.type = "button";
      removeButton.textContent = "Remove";

      item.appendChild(image);
      item.appendChild(removeButton);

      return item;
    };

    const enableSorting = function () {
      if (
        !multiple ||
        !window.jQuery ||
        !window.jQuery.fn.sortable
      ) {
        return;
      }

      const sortablePreview =
        window.jQuery(preview);

      if (
        sortablePreview.hasClass("ui-sortable")
      ) {
        sortablePreview.sortable("destroy");
      }

      sortablePreview.sortable({
        items: ".twl-media-item",
        update: syncIdsFromPreview,
      });
    };

    selectButton.addEventListener(
      "click",
      function () {
        const frame = wp.media({
          title: multiple
            ? "Choose photographs"
            : "Choose photograph",

          button: {
            text: multiple
              ? "Use these photographs"
              : "Use this photograph",
          },

          library: {
            type: "image",
          },

          multiple: multiple,
        });

        frame.on("open", function () {
          const selection =
            frame.state().get("selection");

          getSelectedIds().forEach(function (id) {
            const attachment =
              wp.media.attachment(id);

            attachment.fetch();
            selection.add(attachment);
          });
        });

        frame.on("select", function () {
          const attachments =
            frame
              .state()
              .get("selection")
              .toJSON();

          preview.innerHTML = "";

          attachments.forEach(function (attachment) {
            preview.appendChild(
              createPreviewItem(attachment)
            );
          });

          managedInput.value = "1";
          syncIdsFromPreview();
          enableSorting();
        });

        frame.open();
      }
    );

    preview.addEventListener(
      "click",
      function (event) {
        const removeButton = event.target.closest(
          ".twl-remove-media"
        );

        if (!removeButton) {
          return;
        }

        const item = removeButton.closest(
          ".twl-media-item"
        );

        if (item) {
          item.remove();
          syncIdsFromPreview();
        }
      }
    );

    clearButton.addEventListener(
      "click",
      function () {
        preview.innerHTML = "";
        idsInput.value = "";
        managedInput.value = "1";
      }
    );

    enableSorting();
  });
});