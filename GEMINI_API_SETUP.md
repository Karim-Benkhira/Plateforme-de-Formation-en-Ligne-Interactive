# Gemini AI API Setup for Practice Questions

## Overview

The practice questions system has been developed using **Gemini AI** from Google, which is completely free and provides high-quality questions in English, Arabic, and French.

## Getting Gemini API Key

### Step 1: Create Google AI Studio Account

1. Go to [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Sign in with your Google account
3. If you don't have an account, create one for free

### Step 2: Create API Key

1. In Google AI Studio page, click **"Create API Key"**
2. Choose **"Create API key in new project"** or select an existing project
3. Wait for the key to be generated
4. Copy the key and save it in a secure place

⚠️ **Important Warning**: Do not share your API key with anyone or place it in any public location.

### Step 3: Add Key to Project

1. Open `.env` file in project root
2. Find the line:
   ```
   GEMINI_API_KEY=your-gemini-api-key
   ```
3. Replace `your-gemini-api-key` with your actual key:
   ```
   GEMINI_API_KEY=AIzaSyD...your-actual-api-key-here
   ```

### Step 4: Restart Services

```bash
# Restart Docker containers
docker-compose restart

# Or restart app service only
docker-compose restart app
```

## Testing Setup

### Quick Test

1. Go to any enrolled course
2. Click **"AI Practice Questions"**
3. Click **"Generate New Questions"**
4. Choose desired settings and click **"Generate Questions"**

If questions are generated successfully, your setup is correct!

### Troubleshooting

If questions don't work, check:

1. **API Key Validity**: Make sure you copied the complete key
2. **Internet Connection**: Ensure stable connection
3. **API Limits**: Make sure you haven't exceeded free limits

## Gemini API Free Limits

- **60 requests per minute**
- **1,500 requests per day**
- **1 million tokens per month**

These limits are more than sufficient for normal educational platform usage.

## Available Features

### Supported Question Types

1. **Multiple Choice**: 4 options with one correct answer
2. **True/False**: With detailed explanation
3. **Short Answer**: With key points for evaluation
4. **Mixed**: Combination of all types

### Difficulty Levels

- **Easy**: Basic and straightforward questions
- **Medium**: Questions requiring understanding and analysis
- **Hard**: Questions requiring critical thinking and application

### Supported Languages

- **English**: Default language
- **Arabic**: For Arabic content
- **French**: For French content

## Fallback System

In case Gemini API fails, a local fallback system activates to generate simple questions from course content, ensuring service continuity.

## Security and Privacy

- All data is protected and encrypted
- Course content is not stored on Google servers
- Only small portions are sent for question generation
- All generated questions are stored locally in the database

## Technical Support

If you encounter setup issues:

1. Check `storage/logs/laravel.log` for errors
2. Verify `.env` settings are correct
3. Try restarting services
4. Check Gemini API status in [Google Cloud Console](https://console.cloud.google.com/)

## Usage Tips

### For Students

- Start with easy level then progress to harder
- Read explanations carefully to understand mistakes
- Use questions for review before exams
- Try different question types for variety

### For Teachers

- Encourage students to use practice questions
- Monitor student statistics to identify weak areas
- Use results to improve course content

## Future Updates

- Support for more languages
- New question types (matching, ordering, etc.)
- More detailed analytics
- Smart recommendation system
- Integration with other AI systems

---

**Note**: This feature is completely free and requires no additional fees. Enjoy smart learning! 🚀
