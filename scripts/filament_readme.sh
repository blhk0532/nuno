#!/bin/bash

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
# Clear the output file
> "$output"

  # extract last part of URL (slug)
  slug=$(basename "$repo_urlurl")

  # format the section title → Capitalized
  title=$(echo "$slug" | tr '-' ' ' | sed 's/\b\(.\)/\u\1/g')

  echo "Processing: $repo_url"

  {
    echo -e "\n# $title [$slug]($repo_url)\n"
    curl --no-progress-meter "$repo_url" \
      | html2markdown --include-selector=".prose"
  } >> "$output"

  echo "✅ Done: $title"
done

