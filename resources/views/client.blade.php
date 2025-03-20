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
                            data-contact="{{$c->contactno}}">
                            <i class="bi bi-eye"></i> View
                        </button>

                        <!-- Edit Button -->
                        <a href="edit-client/{{$c->id}}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <!-- Delete Button -->
                        <form action="delete-client/{{$c->id}}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>   
                @endforeach
            </tbody>
        </table>
        {{$client->links()}}
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Client Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
            <form action="{{ route('client.store') }}" method="POST">
                @csrf
                <div class="modal-body">
 <div class="mb-3">
    <label for="clientId" class="form-label">Client ID</label>
    <input type="text" class="form-control" id="clientId" name="clientId" required>
</div>
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mname" name="mname">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactno" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contactno" name="contactno" required>
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
</body>
</html>
