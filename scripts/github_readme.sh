#!/usr/bin/env bash

set -e

if [ -z "$1" ]; then
    echo "Usage: $0 <github-repo-url>"
    exit 1
fi

repo_url="$1"
repo_name=$(basename "$repo_url")
repo_name=${repo_name%.git}

echo "📥 Repo: $repo_name"

output_dir="../docs/$repo_name"
output="$output_dir/README.md"

mkdir -p "$output_dir"

echo "📁 Output: $output"

# --- Detect default branch ---
echo
echo "🔎 Detecting default branch..."
default_branch=$(curl -s "$repo_url" | grep -oP '(?<=branch=)[^"]+' | head -n1)

if [ -z "$default_branch" ]; then
    default_branch="main"
fi

echo "➡️ Default branch: $default_branch"

# --- Build RAW URL ---
raw_url="https://raw.githubusercontent.com/${repo_url#https://github.com/}/$default_branch/README.md"

echo
echo "🌐 Fetching RAW markdown:"
echo "$raw_url"
echo

# --- Download + clean ---
curl --fail --silent "$raw_url" \
    | sed 's/[ \t]*$//' \
    | sed '/^$/N;/^\n$/D' \
    > "$output"

if [ $? -ne 0 ]; then
    echo "❌ Failed to download README.md"
    exit 1
fi

echo
echo "✅ README.md saved!"
echo "📄 $output"
