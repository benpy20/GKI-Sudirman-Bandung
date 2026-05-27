<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - GKI Sudirman</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col items-center justify-center p-4">
    
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 pt-8 pb-6 text-center">
                <div class="mx-auto w-16 h-16 bg-church-warm/30 text-church-dark rounded-full flex items-center justify-center mb-4 border border-church-gold/20">
                    <img src="{{ asset('logo.png') }}" alt="Logo GKI Sudirman" class="w-16 h-16 rounded-full object-cover">
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Login</h1>
                <p class="text-gray-500 text-sm">Silakan masuk ke akun admin GKI Sudirman</p>
            </div>

            <div class="px-8 pb-8">
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" required autofocus value="{{ old('email') }}"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-church-gold focus:border-church-gold transition-colors text-sm text-gray-700"
                                placeholder="Masukkan email..">
                            <i class="fas fa-envelope absolute left-3.5 top-4 text-gray-400"></i>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        </div>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-church-gold focus:border-church-gold transition-colors text-sm text-gray-700"
                                placeholder="Masukkan password..">
                            <i class="fas fa-lock absolute left-3.5 top-4 text-gray-400"></i>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-church-gold focus:ring-church-gold">
                            <span class="text-sm font-medium text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">Forgot password?</a>
                    </div>
                    -->

                    <button type="submit" class="cursor-pointer w-full bg-church-gold hover:bg-church-gold/90 text-white font-bold py-3 px-4 rounded-lg transition-colors mt-4 text-base shadow-md flex items-center justify-center gap-2">
                        <span>Login</span>
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            &copy; 2026 GKI Sudirman Bandung
        </p>
    </div>

</body>
</html>