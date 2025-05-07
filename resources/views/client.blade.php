<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="container mt-4">
        <h2 class="text-center mb-4">Client List</h2>

        <!-- Add Button -->
        <div class="d-flex justify-content-end mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClientModal">
        <i class="bi bi-person-plus"></i> Add Client
    </button>
</div>

<table class="table table-success table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>Client ID</th>
            <th>Image</th>
            <th>Fullname</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($client as $c)
        <tr>
            <td>{{$c->clientId}}</td>
            <td>
                @if($c->image_path)
                    <img src="{{ asset($c->image_path) }}" alt="Client Image" style="width: 50px; height: 50px; object-fit: cover;" class="rounded-circle">
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: white;">
                        <i class="bi bi-person"></i>
                    </div>
                @endif
            </td>
            <td>{{$c->lname}}, {{$c->fname}} {{$c->mname}}</td>
            <td>{{$c->address}}</td>
            <td>{{$c->contactno}}</td>
            <td>
                <!-- View Button -->
                <button class="btn btn-info btn-sm view-client" 
                    data-bs-toggle="modal" 
                    data-bs-target="#clientModal" 
                    data-id="{{$c->clientId}}"
                    data-name="{{$c->lname}}, {{$c->fname}} {{$c->mname}}"
                    data-address="{{$c->address}}"
                    data-contact="{{$c->contactno}}"
                    data-image="{{$c->image_path}}">
                    <i class="bi bi-eye"></i> View
                </button>

                <!-- Edit Button -->
                <button class="btn btn-warning btn-sm edit-client"
                    data-bs-toggle="modal"
                    data-bs-target="#editClientModal"
                    data-id="{{$c->id}}"
                    data-clientId="{{$c->clientId}}"
                    data-fname="{{$c->fname}}"
                    data-mname="{{$c->mname}}"
                    data-lname="{{$c->lname}}"
                    data-address="{{$c->address}}"
                    data-contact="{{$c->contactno}}"
                    data-image="{{$c->image_path}}">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>

                <!-- Delete Button -->
                <button class="btn btn-danger btn-sm delete-client" 
                    data-id="{{$c->id}}" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteConfirmModal">
                    <i class="bi bi-trash"></i> Delete
                </button>
                <form action="{{ route('client.destroy', $c->id) }}" method="POST" class="delete-form d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>   
        @endforeach
    </tbody>
</table>
        {{$client->links()}}
    </div>

    

    <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Client Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="modal-clientImage" src="" alt="Client Photo" class="img-thumbnail" style="max-height: 200px;">
                        <div id="modal-noImage" class="bg-secondary rounded d-none mx-auto d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; color: white;">
                            <i class="bi bi-person" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <p><strong>Client ID:</strong> <span id="modal-clientId"></span></p>
                    <p><strong>Full Name:</strong> <span id="modal-clientName"></span></p>
                    <p><strong>Address:</strong> <span id="modal-clientAddress"></span></p>
                    <p><strong>Contact Number:</strong> <span id="modal-clientContact"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS & jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".view-client").click(function() {
                var clientId = $(this).data("id");
                var clientName = $(this).data("name");
                var clientAddress = $(this).data("address");
                var clientContact = $(this).data("contact");

                $("#modal-clientId").text(clientId);
                $("#modal-clientName").text(clientName);
                $("#modal-clientAddress").text(clientAddress);
                $("#modal-clientContact").text(clientContact);
            });
        });
    </script>
    
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="clientId" class="form-label">Client ID (Auto-generated)</label>
                        <input type="text" class="form-control bg-light" id="clientId" value="{{ $nextClientId }}" readonly>
                        <!-- Hidden field to hold the clientId value -->
                        <input type="hidden" name="clientId" value="{{ $nextClientId }}">
                    </div>
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" minlength="2" required>
                    </div>
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mname" name="mname" minlength="2">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" minlength="2" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" minlength="2" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactno" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contactno" name="contactno" minlength="2" required>
                    </div>
                    <div class="mb-3">
                        <label for="client_image" class="form-label">Client Image</label>
                        <input type="file" class="form-control" id="client_image" name="client_image" accept="image/*">
                        <div id="imagePreview" class="mt-2 d-none">
                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Client</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editClientForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <input type="hidden" id="edit-client-id" name="id">

                    <div class="mb-3">
                        <label for="edit-clientId" class="form-label">Client ID</label>
                        <input type="text" class="form-control" id="edit-clientId" name="clientId" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="edit-fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="edit-fname" name="fname"
                               value="{{ old('fname') }}"required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="edit-mname" name="mname"
                               value="{{ old('mname', $client->mname ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="edit-lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="edit-lname" name="lname"
                               value="{{ old('lname', $client->lname ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="edit-address" name="address"
                               value="{{ old('address', $client->address ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-contactno" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="edit-contactno" name="contactno"
                               value="{{ old('contactno', $client->contactno ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-client-image" class="form-label">Client Image</label>
                        <input type="file" class="form-control" id="edit-client-image" name="client_image" accept="image/*">
                        <div id="edit-current-image" class="mt-2">
                            <p class="mb-1">Current Image:</p>
                            <img src="" alt="No image available" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                        <div id="edit-image-preview" class="mt-2 d-none">
                            <p class="mb-1">New Image Preview:</p>
                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Client</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(".edit-client").click(function() {
        var id = $(this).data("id");
        var clientId = $(this).data("clientid");
        var fname = $(this).data("fname");
        var mname = $(this).data("mname");
        var lname = $(this).data("lname");
        var address = $(this).data("address");
        var contactno = $(this).data("contact");

        $("#edit-client-id").val(id);
        $("#edit-clientId").val(clientId);
        $("#edit-fname").val(fname);
        $("#edit-mname").val(mname);
        $("#edit-lname").val(lname);
        $("#edit-address").val(address);
        $("#edit-contactno").val(contactno);

        $("#editClientForm").attr("action", "/update-client/" + id);
    });
});
</script>
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this client?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var deleteForm;

        $(".delete-client").click(function() {
            deleteForm = $(this).closest("td").find(".delete-form");
        });

        $("#confirmDelete").click(function() {
            if (deleteForm) {
                deleteForm.submit();
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("clientId").addEventListener("input", function () {
        this.value = this.value.replace(/\s/g, ""); // Prevent spaces in client ID
    });

    document.getElementById("contactno").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, ""); // Allow only numbers
    });

    document.querySelector("form").addEventListener("submit", function (e) {
        let clientId = document.getElementById("clientId").value.trim();
        let fname = document.getElementById("fname").value.trim();
        let mname = document.getElementById("mname").value.trim();
        let lname = document.getElementById("lname").value.trim();
        let address = document.getElementById("address").value.trim();
        let contactno = document.getElementById("contactno").value.trim();

        if (fname.length < 2 || lname.length < 2 || address.length < 2) {
            alert("First Name, Last Name, and Address must be at least 2 characters long.");
            e.preventDefault();
            return;
        }

        if (mname.length > 0 && mname.length < 2) {
            alert("Middle Name must be at least 2 characters long.");
            e.preventDefault();
            return;
        }

        if (!/^\d+$/.test(contactno)) {
            alert("Contact number must contain only numbers.");
            e.preventDefault();
            return;
        }
    });
});

</script>

<script>
    document.getElementById("clientId").addEventListener("blur", function () {
    let clientId = this.value.trim();
    
    if (clientId.length > 0) {
        fetch(`/check-client-id/${clientId}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    alert("Client ID already exists. Please use a different one.");
                    this.value = "";
                }
            })
            .catch(error => console.error("Error:", error));
    }
});

</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("#editClientForm");
        const inputs = document.querySelectorAll("#editClientForm input[type='text']");

        // Store initial values when modal opens
        let originalValues = {};

        document.getElementById("editClientModal").addEventListener("shown.bs.modal", function () {
            inputs.forEach(input => {
                originalValues[input.name] = input.value; // Store the original values
            });
        });

        // Restore values when input is left empty
        inputs.forEach(input => {
            input.addEventListener("blur", function () {
                if (this.value.trim() === "") {
                    this.value = originalValues[this.name]; // Restore original value
                }
            });
        });

        // Prevent form submission if no real changes were made
        form.addEventListener("submit", function (event) {
            let hasChanges = false;

            inputs.forEach(input => {
                if (input.value.trim() !== originalValues[input.name]) {
                    hasChanges = true; // A change was made
                }
            });

            if (!hasChanges) {
                event.preventDefault(); // Stop form submission if no changes were made
                alert("No changes detected!"); // Optional alert for user
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    // Form validation for add client
    document.querySelector("#addClientModal form").addEventListener("submit", function (e) {
        let fname = document.getElementById("fname").value.trim();
        let mname = document.getElementById("mname").value.trim();
        let lname = document.getElementById("lname").value.trim();
        let address = document.getElementById("address").value.trim();
        let contactno = document.getElementById("contactno").value.trim();

        if (fname.length < 2 || lname.length < 2 || address.length < 2) {
            alert("First Name, Last Name, and Address must be at least 2 characters long.");
            e.preventDefault();
            return;
        }

        if (mname.length > 0 && mname.length < 2) {
            alert("Middle Name must be at least 2 characters long.");
            e.preventDefault();
            return;
        }

        if (!/^\d+$/.test(contactno)) {
            alert("Contact number must contain only numbers.");
            e.preventDefault();
            return;
        }
    });

    // Contact number validation - allow only numbers
    document.getElementById("contactno").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, ""); // Allow only numbers
    });

    document.addEventListener("DOMContentLoaded", function () {
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(function() {
            const closeButton = successAlert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            } else {
                successAlert.classList.remove('show');
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }
        }, 5000);
    }
});
});

document.addEventListener('DOMContentLoaded', function () {
    const addClientModal = document.getElementById('addClientModal');
    if (addClientModal) {
        addClientModal.addEventListener('show.bs.modal', function () {
            // Make an AJAX request to get the next client ID
            fetch('/get-next-client-id')
                .then(response => response.json())
                .then(data => {
                    if (data.nextClientId) {
                        document.getElementById('clientId').value = data.nextClientId;
                        document.querySelector('input[name="clientId"]').value = data.nextClientId;
                    }
                })
                .catch(error => console.error('Error fetching next client ID:', error));
        });
    }
});

$(document).ready(function() {
    // Add client - Image preview
    $("#client_image").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").removeClass("d-none");
                $("#imagePreview img").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            $("#imagePreview").addClass("d-none");
        }
    });

    // Edit client - Image preview
    $("#edit-client-image").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#edit-image-preview").removeClass("d-none");
                $("#edit-image-preview img").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            $("#edit-image-preview").addClass("d-none");
        }
    });

    // View client modal
    $(".view-client").click(function() {
        var clientId = $(this).data("id");
        var clientName = $(this).data("name");
        var clientAddress = $(this).data("address");
        var clientContact = $(this).data("contact");
        var clientImage = $(this).data("image");

        $("#modal-clientId").text(clientId);
        $("#modal-clientName").text(clientName);
        $("#modal-clientAddress").text(clientAddress);
        $("#modal-clientContact").text(clientContact);
        
        // Handle client image
        if (clientImage) {
            $("#modal-clientImage").attr("src", "/" + clientImage).removeClass("d-none");
            $("#modal-noImage").addClass("d-none");
        } else {
            $("#modal-clientImage").addClass("d-none");
            $("#modal-noImage").removeClass("d-none");
        }
    });

    // Edit client modal
    $(".edit-client").click(function() {
        var id = $(this).data("id");
        var clientId = $(this).data("clientid");
        var fname = $(this).data("fname");
        var mname = $(this).data("mname");
        var lname = $(this).data("lname");
        var address = $(this).data("address");
        var contactno = $(this).data("contact");
        var imagePath = $(this).data("image");

        $("#edit-client-id").val(id);
        $("#edit-clientId").val(clientId);
        $("#edit-fname").val(fname);
        $("#edit-mname").val(mname);
        $("#edit-lname").val(lname);
        $("#edit-address").val(address);
        $("#edit-contactno").val(contactno);
        
        // Handle current image display
        if (imagePath) {
            $("#edit-current-image img").attr("src", "/" + imagePath);
            $("#edit-current-image").show();
        } else {
            $("#edit-current-image img").attr("src", "");
            $("#edit-current-image p").text("No current image");
        }
        
        // Hide the new image preview
        $("#edit-image-preview").addClass("d-none");

        $("#editClientForm").attr("action", "/update-client/" + id);
    });
});

</script>

</body>
</html>
