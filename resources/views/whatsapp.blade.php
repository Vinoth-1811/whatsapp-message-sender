<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Message Sender | Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #25D366;
            --dark-color: #075E54;
            --light-color: #DCF8C6;
        }

        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 211, 102, 0.25);
        }

        .btn-submit {
            background-color: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: var(--dark-color);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
        }

        .whatsapp-icon {
            font-size: 2rem;
            margin-right: 10px;
            vertical-align: middle;
        }

        .input-group-text {
            background-color: var(--light-color);
            border: 1px solid #e0e0e0;
            border-right: none;
        }

        .container {
            max-width: 800px;
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .floating-label label {
            position: absolute;
            top: -10px;
            left: 15px;
            background: white;
            padding: 0 5px;
            font-size: 0.8rem;
            color: var(--dark-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center">
                        <i class="fab fa-whatsapp whatsapp-icon"></i>
                        <h2 class="d-inline-block mb-0">WhatsApp Message Sender</h2>
                        <p class="mb-0 mt-2">Send messages through Twilio's WhatsApp API</p>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('whatsapp.post') }}">
                            @csrf

                            <!-- Success Message -->
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Error Message -->
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Phone Number Field -->
                            <div class="mt-4">
                                <label for="phone">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="+919876543210"
                                        value="{{ old('phone') }}">
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Message Field -->
                            <div class="mt-4">
                                <label for="message">Message</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                    <textarea
                                        name="message"
                                        id="message"
                                        rows="4"
                                        class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Type your message here...">{{ old('message') }}</textarea>
                                </div>
                                @error('message')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-submit btn-lg">
                                    <i class="fab fa-whatsapp me-2"></i> Send WhatsApp Message
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-muted text-center">
                        <small>Powered by Twilio WhatsApp API & Laravel</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Success alert
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    const alert = new bootstrap.Alert(successAlert);
                    alert.close();
                }, 5000);
            }

            // Error alert
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                setTimeout(() => {
                    const alert = new bootstrap.Alert(errorAlert);
                    alert.close();
                }, 5000);
            }
        });
    </script>
</body>
</html>
