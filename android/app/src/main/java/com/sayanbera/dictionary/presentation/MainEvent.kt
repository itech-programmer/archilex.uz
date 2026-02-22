package com.sayanbera.dictionary.presentation

import android.content.Context
import com.sayanbera.dictionary.domain.model.DictionaryCategory

sealed class MainEvent {
    data class OnSearchClick(val context: Context) : MainEvent()
    data class OnInputWordChange(val inputWord: String) : MainEvent()
    data class OnCategorySelect(val category: DictionaryCategory) : MainEvent()
}