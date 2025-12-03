@props([
    'id' => 0
])

<tr>
    {{ $slot }}

    <td>
        <button 
            class="btn theme-button update-btn" 
            data-id="{{ $id }}"
            data-bs-toggle="modal" 
            data-bs-target="#updateModal"
        >
            Update
        </button>
    </td>
    <td>
        <button 
            class="btn theme-button delete-btn" 
            data-id="{{ $id }}"
            data-bs-toggle="modal" 
            data-bs-target="#deleteModal"
        >
            Delete
        </button>
    </td>
</tr>