#!/usr/bin/env node

/**
 * Test phone number normalization
 */

function normalizePhoneNumber(rawPhone) {
  if (!rawPhone || typeof rawPhone !== 'string') {
    return null;
  }

  // Remove all spaces, dashes, and parentheses
  let cleaned = rawPhone.replace(/[\s\-()]/g, '');

  // If already starts with +46, keep it
  if (cleaned.startsWith('+46')) {
    // Must have at least 10 digits after +46 (total 12 chars minimum: +46XXXXXXXXXX)
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

// Test cases
const testCases = [
  // Complete numbers
  { input: '070-123 45 67', expected: '+46701234567' },
  { input: '+46701234567', expected: '+46701234567' },
  { input: '0701234567', expected: '+46701234567' },
  { input: '+46 70 123 45 67', expected: '+46701234567' },
  { input: '073-645 87 83', expected: '+46736458783' },
  { input: '+46736784940', expected: '+46736784940' },
  { input: '+46731417311', expected: '+46731417311' },
  
  // Incomplete numbers (should return null)
  { input: '073-642 11', expected: null },
  { input: '070-467 20', expected: null },
  { input: '070-586 76', expected: null },
  { input: '072-300 88', expected: null },
  { input: '+46 73 642 11', expected: null },
  { input: '0736421', expected: null },
  
  // Edge cases
  { input: '', expected: null },
  { input: null, expected: null },
  { input: 'not a phone', expected: null },
];

console.log('Testing phone number normalization:\n');
let passed = 0;
let failed = 0;

testCases.forEach(({ input, expected }) => {
  const result = normalizePhoneNumber(input);
  const pass = result === expected;
  
  if (pass) {
    passed++;
    console.log(`✓ "${input}" → ${result === null ? 'null' : result}`);
  } else {
    failed++;
    console.log(`✗ "${input}" → ${result === null ? 'null' : result} (expected: ${expected === null ? 'null' : expected})`);
  }
});

console.log(`\nResults: ${passed} passed, ${failed} failed`);
process.exit(failed > 0 ? 1 : 0);
