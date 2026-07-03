<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Create Your Account</title>
        <!-- Tailwind CSS for modern, clean styling -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body
        class="bg-gray-50 flex items-center justify-center min-h-screen p-4 text-gray-800"
    >
        <div
            class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-gray-100"
        >
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    Create an Account
                </h1>
                <p class="text-sm text-gray-500 mt-2">
                    Join us to access your services
                </p>
            </div>

            <!-- Registration Form -->
            <form id="registrationForm" class="space-y-5">
                <!-- Required: Email -->
                <div>
                    <label
                        for="email"
                        class="block text-sm font-semibold mb-1.5"
                        >Email Address
                        <span class="text-red-500">*</span></label
                    >
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        autocomplete="email"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="you@example.com"
                    />
                </div>

                <!-- Required: Password -->
                <div>
                    <label
                        for="password"
                        class="block text-sm font-semibold mb-1.5"
                        >Password <span class="text-red-500">*</span></label
                    >
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="••••••••"
                    />
                    <p class="text-xs text-gray-400 mt-1">
                        Must be at least 8 characters
                    </p>
                </div>

                <!-- Divider for Optional Fields -->
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span
                        class="flex-shrink mx-4 text-xs text-gray-400 uppercase tracking-wider font-medium"
                        >Optional Information</span
                    >
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <!-- Grid for Optional Fields -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Optional: Age -->
                    <div>
                        <label
                            for="age"
                            class="block text-sm font-semibold mb-1.5 text-gray-600"
                            >Age</label
                        >
                        <input
                            type="number"
                            id="age"
                            name="age"
                            min="0"
                            max="120"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm"
                            placeholder="e.g. 25"
                        />
                    </div>

                    <!-- Optional: Gender -->
                    <div>
                        <label
                            for="gender"
                            class="block text-sm font-semibold mb-1.5 text-gray-600"
                            >Gender</label
                        >
                        <select
                            id="gender"
                            name="gender"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm bg-white"
                        >
                            <option value="">Select...</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                            <option value="non-binary">Non-binary</option>
                            <option value="other">Other</option>
                            <option value="prefer-not-to-say">
                                Prefer not to say
                            </option>
                        </select>
                    </div>

                    <!-- Optional: Nationality -->
                    <div>
                        <label
                            for="nationality"
                            class="block text-sm font-semibold mb-1.5 text-gray-600"
                            >Nationality</label
                        >
                        <input
                            type="text"
                            id="nationality"
                            name="nationality"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm"
                            placeholder="e.g. Canadian"
                        />
                    </div>

                    <!-- Optional: City of Origin -->
                    <div>
                        <label
                            for="city_of_origin"
                            class="block text-sm font-semibold mb-1.5 text-gray-600"
                            >City of Origin</label
                        >
                        <input
                            type="text"
                            id="city_of_origin"
                            name="city_of_origin"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm"
                            placeholder="e.g. Toronto"
                        />
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 cursor-pointer"
                >
                    Register Account
                </button>
            </form>

            <!-- Footer link -->
            <p class="text-center text-sm text-gray-500 mt-6">
                Already have an account?
                <a href="#" class="text-blue-600 hover:underline font-medium"
                    >Log in</a
                >
            </p>
        </div>

        <!-- Example JavaScript to handle form submission via JSON API -->
        <script>
            document
                .getElementById("registrationForm")
                .addEventListener("submit", async (e) => {
                    e.preventDefault();

                    const formData = new FormData(e.target);
                    const payload = Object.fromEntries(formData.entries());

                    // Clean up optional numeric fields so they aren't sent as empty strings
                    if (!payload.age) delete payload.age;
                    if (!payload.gender) delete payload.gender;
                    if (!payload.nationality) delete payload.nationality;
                    if (!payload.city_of_origin) delete payload.city_of_origin;

                    console.log("Sending to Auth API:", payload);

                    /* 
            // When you choose your routing, this is how you would send it to your Headless API:
            try {
                const response = await fetch('https://auth.yourdomain.com/api/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();
                if (response.ok) {
                    alert('Registration successful!');
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (err) {
                console.error('Network error:', err);
            }
            */
                });
        </script>
    </body>
</html>
