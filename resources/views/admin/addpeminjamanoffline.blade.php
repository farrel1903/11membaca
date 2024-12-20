@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <h2>Form Tambah Peminjaman Offline</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="card" style="background-color: #afb3b7; padding: 20px;">
                            <form action="{{ route('transaksi.store') }}" method="POST" id="peminjamanForm">
                                @csrf
                            
                                <!-- Input untuk NIS/NIK -->
                                <div class="mb-4">
                                    <label for="nis_nik" class="form-label">NIS/NIK</label>
                                    <select class="form-control" name="nis_nik" id="nis_nik" required>
                                        <option value="">Pilih NIS/NIK</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->nis_nik }}">{{ $member->nis_nik }} - {{ $member->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <!-- Kontainer Input Buku -->
                                <div id="inputBukuContainer">
                                    <div class="row mb-4 buku-input">
                                        <div class="col-md-10 mb-3">
                                            <label for="id_buku_anak[]" class="form-label">ID Buku Anak</label>
                                            <select class="form-control" name="id_buku_anak[]" required>
                                                <option value="">Pilih Buku</option>
                                                @foreach ($bukuAnak as $bukuItem)
                                                    <option value="{{ $bukuItem->id_buku_anak }}">{{ $bukuItem->judul }} ({{ $bukuItem->id_buku_anak }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Tombol Hapus disembunyikan secara default -->
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-buku" style="display: none;">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Tombol Tambah Input Buku -->
                                <div class="text-center mb-3">
                                    <button type="button" class="btn btn-secondary" id="addBukuButton">Tambah Buku</button>
                                </div>
                            
                                <!-- Tombol Submit -->
                                <div class="text-center">
                                    <button style="font-weight: bold" type="submit" class="btn btn-warning">Simpan</button>
                                </div>
                            </form>                                                        
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- <script>
    document.getElementById('addBukuButton').addEventListener('click', function() {
        const bukuContainer = document.getElementById('inputBukuContainer');
        const currentInputs = bukuContainer.getElementsByClassName('buku-input').length;

        // Batasi jumlah inputan menjadi maksimal 2
        const newInput = document.createElement('div');
        newInput.classList.add('row', 'mb-4', 'buku-input');
        newInput.innerHTML = `
            <div class="col-md-6 mb-3">
                <label for="id_buku_anak[]" class="form-label">ID Buku Anak</label>
                <select class="form-control" name="id_buku_anak[]" required>
                    <option value="">Pilih Buku</option>
                    @foreach ($bukuAnak as $bukuItem)
                        <option value="{{ $bukuItem->id_buku_anak }}">{{ $bukuItem->judul }} ({{ $bukuItem->id_buku_anak }})</option>
                    @endforeach
                </select>
            </div>
        `;
        bukuContainer.appendChild(newInput);

        // Tampilkan tombol "Close"
        document.getElementById('closeBukuButton').style.display = 'inline-block';
    });

    document.getElementById('closeBukuButton').addEventListener('click', function() {
        const bukuContainer = document.getElementById('inputBukuContainer');
        // Hapus input buku terakhir yang ditambahkan
        const inputs = bukuContainer.getElementsByClassName('buku-input');
        
        // Hanya hapus input buku terakhir jika lebih dari 1 input
        if (inputs.length > 1) {
            bukuContainer.removeChild(inputs[inputs.length - 1]);
        }
        
        // Jika tidak ada lagi input buku kedua, sembunyikan tombol "Close"
        if (inputs.length <= 2) {
            this.style.display = 'none';
        }
    });
</script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const addBukuButton = document.getElementById("addBukuButton");
    const inputBukuContainer = document.getElementById("inputBukuContainer");

    // Fungsi untuk memperbarui tombol hapus
    function updateRemoveButtons() {
        const allRows = inputBukuContainer.querySelectorAll(".buku-input");
        const removeButtons = inputBukuContainer.querySelectorAll(".remove-buku");

        removeButtons.forEach((button, index) => {
            button.style.display = allRows.length > 1 ? "inline-block" : "none";
        });
    }

    // Tambah Input Buku
    addBukuButton.addEventListener("click", function () {
        const newInputRow = document.createElement("div");
        newInputRow.classList.add("row", "mb-4", "buku-input");
        newInputRow.innerHTML = `
            <div class="col-md-10 mb-3">
                <label for="id_buku_anak[]" class="form-label">ID Buku Anak</label>
                <select class="form-control" name="id_buku_anak[]" required>
                    <option value="">Pilih Buku</option>
                    @foreach ($bukuAnak as $bukuItem)
                        <option value="{{ $bukuItem->id_buku_anak }}">{{ $bukuItem->judul }} ({{ $bukuItem->id_buku_anak }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-buku">Hapus</button>
            </div>
        `;
        inputBukuContainer.appendChild(newInputRow);
        updateRemoveButtons(); // Perbarui tombol hapus
    });

    // Hapus Input Buku
    inputBukuContainer.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-buku")) {
            const inputRow = event.target.closest(".buku-input");
            inputRow.remove();
            updateRemoveButtons(); // Perbarui tombol hapus
        }
    });

    // Perbarui tombol hapus saat pertama kali
    updateRemoveButtons();
});
</script>