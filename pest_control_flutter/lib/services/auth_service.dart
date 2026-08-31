import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class AuthService {
  static const String baseUrl =
      'https://pestcontrolsfi.infinityfreeapp.com';

  Future<Map<String, dynamic>> login(
    String email,
    String password,
  ) async {
    final response = await http.post(
      Uri.parse('$baseUrl/api/login'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: {
        'email': email,
        'password': password,
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final token = data['data']['token'];

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('token', token);

      return data;
    }

    throw Exception(data['message'] ?? 'Login gagal');
  }
}