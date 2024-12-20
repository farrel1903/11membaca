@extends('layouts.layoutuser')

@section('title', 'Membaca ' . $buku->judul)

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Membaca eBook: <span class="text-primary">{{ $buku->judul }}</span></h2>
    <input type="hidden" id="id_buku" value="{{$buku->id_buku_induk}}">
    <div class="pdf-viewer d-flex justify-content-center align-items-center position-relative">
        <!-- Tombol Navigasi Kiri (Tengah Secara Vertikal) -->
        <button id="prev" class="btn btn-primary nav-button left-button position-absolute" style="top: 50%; transform: translateY(-50%); left: 10px;">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Canvas untuk Halaman Kiri dan Kanan (Horizontal) -->
        <div class="d-flex">
            <canvas id="pdf-canvas-left" class="shadow-sm mb-3" style="border: 1px solid #ddd; margin-right: 10px;"></canvas>
            <canvas id="pdf-canvas-right" class="shadow-sm" style="border: 1px solid #ddd;"></canvas>
        </div>

        <!-- Tombol Navigasi Kanan (Tengah Secara Vertikal) -->
        <button id="next" class="btn btn-primary nav-button right-button position-absolute" style="top: 50%; transform: translateY(-50%); right: 10px;">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <div class="mt-4 text-center">
        <label for="page-info" class="me-2 fw-bold">Halaman:</label>
        <span id="page-info" class="me-3 badge bg-secondary">1</span>
        <div class="d-inline-flex align-items-center">
            <input type="number" id="page-input" class="form-control me-2" style="width: 80px;" min="1" placeholder="No." value="{{ $halamanTerakhir }}">
            <button id="go-to-page" class="btn btn-outline-secondary">Ke Halaman</button>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-between">
        <button id="first" class="btn btn-success">Paling Awal</button>
        <button id="last" class="btn btn-success">Paling Akhir</button>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('pengguna.produk.index') }}" id="backToProducts" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Produk
        </a>
    </div>
</div>
    <!-- Include PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    <script>
        // Ambil ID Buku dari elemen HTML
        const id_buku = document.getElementById('id_buku').value;
        const url = "{{ asset('ebook_pdf/' . $buku->ebook) }}";  // Path file PDF
        let pdfDoc = null,
            pageNum = 1,
            pageIsRendering = false,
            pageNumIsPending = null;
    
        const canvasLeft = document.getElementById('pdf-canvas-left');
        const canvasRight = document.getElementById('pdf-canvas-right');
        const ctxLeft = canvasLeft.getContext('2d');
        const ctxRight = canvasRight.getContext('2d');
        const pageInfo = document.getElementById('page-info');
    
        // Ambil halaman terakhir yang dibaca dari controller (pastikan sudah ada data halaman terakhir yang valid)
        const lastPage = {{ $halamanTerakhir ?? 1 }};  // Pastikan halaman terakhir yang dibaca diambil dari controller
        pageNum = lastPage > 0 ? lastPage : 1;  // Menetapkan pageNum ke halaman terakhir atau halaman pertama jika tidak ada
    
        // Fungsi untuk merender halaman
        const renderPage = (num) => {
            pageIsRendering = true;
    
            // Render halaman kiri
            pdfDoc.getPage(num).then((page) => {
                const viewport = page.getViewport({ scale: 0.75 });
                canvasLeft.height = viewport.height;
                canvasLeft.width = viewport.width;
    
                const renderContext = { canvasContext: ctxLeft, viewport: viewport };
                page.render(renderContext).promise.then(() => {
                    pageIsRendering = false;
                    if (pageNumIsPending !== null) {
                        renderPage(pageNumIsPending);
                        pageNumIsPending = null;
                    }
                });
            }).catch((error) => {
                console.error('Error rendering page ' + num, error);
            });
    
            // Render halaman kanan jika ada
            if (num + 1 <= pdfDoc.numPages) {
                pdfDoc.getPage(num + 1).then((page) => {
                    const viewport = page.getViewport({ scale: 0.75 });
                    canvasRight.height = viewport.height;
                    canvasRight.width = viewport.width;
    
                    const renderContext = { canvasContext: ctxRight, viewport: viewport };
                    page.render(renderContext);
                }).catch((error) => {
                    console.error('Error rendering page ' + (num + 1), error);
                });
            }
    
            // Perbarui info halaman
            pageInfo.textContent = `${num} - ${Math.min(num + 1, pdfDoc.numPages)} dari ${pdfDoc.numPages}`;
    
            // Menyimpan halaman terakhir yang dibaca
            saveLastPage(num);
    
            // Update status tombol navigasi
            document.getElementById('prev').disabled = num <= 1;
            document.getElementById('next').disabled = num >= pdfDoc.numPages - 1;
        };
    
        // Fungsi untuk menjadwalkan render halaman
        const queueRenderPage = (num) => {
            if (pageIsRendering) {
                pageNumIsPending = num;
            } else {
                renderPage(num);
            }
        };
    
        // Fungsi untuk menampilkan PDF
        const showPDF = (url) => {
            pdfjsLib.getDocument(url).promise.then((pdfDoc_) => {
                pdfDoc = pdfDoc_;
                renderPage(pageNum);  // Render dari halaman yang sudah disesuaikan
            }).catch((error) => {
                console.error('Error loading PDF: ', error);
            });
        };
    
        // Fungsi untuk menyimpan halaman terakhir yang dibaca
        const saveLastPage = (pageNum) => {
            fetch(`/save-last-page?id_buku=${id_buku}&page=${pageNum}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Halaman terakhir berhasil disimpan:', data);
            })
            .catch(error => {
                console.error('Terjadi kesalahan saat menyimpan halaman terakhir:', error);
            });
        };
    
        // Tombol navigasi
        document.getElementById('prev').addEventListener('click', () => {
            if (pageNum <= 1) return;  // Pindah satu halaman ke belakang
            pageNum -= 1;
            queueRenderPage(pageNum);
        });
    
        document.getElementById('next').addEventListener('click', () => {
            if (pageNum >= pdfDoc.numPages) return;  // Pindah satu halaman ke depan
            pageNum += 1;
            queueRenderPage(pageNum);
        });
    
        // Tombol Paling Awal
        document.getElementById('first').addEventListener('click', () => {
            pageNum = 1;
            queueRenderPage(pageNum);
        });
    
        // Tombol Paling Akhir
        document.getElementById('last').addEventListener('click', () => {
            pageNum = pdfDoc.numPages - (pdfDoc.numPages % 2 === 0 ? 1 : 0);  // Pastikan halaman kiri diakhiri genap
            queueRenderPage(pageNum);
        });
    
        // Tombol Ke Halaman
        document.getElementById('go-to-page').addEventListener('click', () => {
            const pageInput = parseInt(document.getElementById('page-input').value);
            if (isNaN(pageInput) || pageInput < 1 || pageInput > pdfDoc.numPages) {
                alert("Masukkan nomor halaman yang valid!");
                return;
            }
            pageNum = pageInput % 2 === 0 ? pageInput - 1 : pageInput;  // Pastikan halaman kiri selalu ganjil
            queueRenderPage(pageNum);
        });
    
        // Cegah klik kanan pada canvas
        document.getElementById('pdf-canvas-left').addEventListener('contextmenu', (e) => e.preventDefault());
        document.getElementById('pdf-canvas-right').addEventListener('contextmenu', (e) => e.preventDefault());
    
        // Tampilkan PDF dimulai dari halaman terakhir yang dibaca
        showPDF(url);
    </script>
        
    
    <style>
        .pdf-viewer {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            overflow: hidden;
            width: 90%;
            height: 600px;
            position: relative;
            margin: 0 auto;
        }

        canvas {
            display: block;
            width: 45%;
            margin: 0 1%;
            pointer-events: none;
        }

        .nav-button {
            z-index: 10;
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: box-shadow 0.1s;
            min-width: 40px;
            height: 40px;
        }

        .nav-button:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        .rating {
            display: flex;
            cursor: pointer;
        }

        .star {
            font-size: 2rem;
            color: #ccc;
            transition: color 0.2s;
        }

        .star.selected {
            color: gold;
        }

        .modal {
            z-index: 1050;
            /* Pastikan modal berada di atas elemen lain */
        }

        .modal-dialog {
            top: 50%;
            /* Posisikan di tengah vertikal */
            transform: translateY(-50%);
            /* Ubah transformasi untuk benar-benar di tengah */
        }
    </style>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
