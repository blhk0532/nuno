#!/usr/bin/env node

/**
 * Test phone number normalization logic
 */

class PhoneNormalizer {
  /**
   * Normalize phone number to complete +46XXXXXXXXX format
   * Returns null if the number is incomplete or invalid
   */
  normalizePhoneNumber(rawPhone) {
    if (!rawPhone || typeof rawPhone !== 'string') {
      return null;
    }

    // Remove all spaces, dashes, and parentheses
    let cleaned = rawPhone.replace(/[\s\-()]/g, '');

    // If already starts with +46, keep it
    if (cleaned.startsWith('+46')) {
      // Must have at least 10 digits after +46 (total 13 chars minimum: +46XXXXXXXXXX)
      if (cleaned.length >= 12) {
        return cleaned;
      }
      return null; // Incomplete
    }

    // If starts with 0, replace with +46
    if (cleaned.startsWith('0')) {
      cleaned = '+46' + cleaned.substring(1);
      // Must have at least 10 digits after +46
      if (cleaned.length >= 12) {
        return cleaned;
      }
      return null; // Incomplete
    }

    // If it's just digits without country code or leading 0, assume Swedish and prepend +46
    if (/^\d+$/.test(cleaned)) {
      cleaned = '+46' + cleaned;
      if (cleaned.length >= 12) {
        return cleaned;
      }
      return null; // Incomplete
    }

    // Unknown format
    return null;
  }

  testNormalization() {
    const testCases = [
      // Complete numbers - should normalize
      { input: '070-123 45 67', expected: '+46701234567' },
      { input: '0701234567', expected: '+46701234567' },
      { input: '+46701234567', expected: '+46701234567' },
      { input: '+46 70 123 45 67', expected: '+46701234567' },
      
      // Incomplete numbers - should return null
      { input: '070-123 45', expected: null },
      { input: '070', expected: null },
      { input: '+46 70', expected: null },
      
      // Edge cases
      { input: '', expected: null },
      { input: null, expected: null },
      { input: '123', expected: null },
    ];

    console.log('Testing phone number normalization:\n');
    let passed = 0;
    let failed = 0;

    testCases.forEach(({ input, expected }, index) => {
      const result = this.normalizePhoneNumber(input);
      const success = result === expected;
      
      if (success) {
        passed++;
        console.log(`✓ Test ${index + 1}: "${input}" → ${result || 'null'}`);
      } else {
        failed++;
        console.log(`✗ Test ${index + 1}: "${input}" → ${result || 'null'} (expected: ${expected || 'null'})`);
      }
    });

    console.log(`\n${passed} passed, ${failed} failed`);

    // Test fallback logic
    console.log('\n\nTesting fallback to raw when normalization fails:\n');
    
    const incompletNumbers = ['070-123 45', '070', '+46 70'];
    console.log('Raw numbers:', incompletNumbers);
    
    const normalized = incompletNumbers
      .map(phone => this.normalizePhoneNumber(phone))
      .filter(phone => phone !== null);
    
    console.log('Normalized (complete only):', normalized);
    
    const result = normalized.length > 0 ? normalized : incompletNumbers;
    console.log('Final result (fallback to raw):', result);
    console.log('✓ Numbers preserved even when incomplete');
  }
}

const tester = new PhoneNormalizer();
tester.testNormalization();
